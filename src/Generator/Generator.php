<?php

namespace CakeDto\Generator;

use CakeDto\Console\Io;
use CakeDto\View\Renderer;
use Cake\Console\Shell;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Generator {

	use DiffHelperTrait;

	const CODE_CHANGES = 2;
	const CODE_SUCCESS = Shell::CODE_SUCCESS;
	const CODE_ERROR = Shell::CODE_ERROR;

	/**
	 * @var \CakeDto\Generator\Builder
	 */
	protected $builder;

	/**
	 * @var \CakeDto\View\Renderer
	 */
	protected $renderer;

	/**
	 * @var \CakeDto\Console\Io
	 */
	protected $io;

	/**
	 * @param \CakeDto\Generator\Builder $builder
	 * @param \CakeDto\View\Renderer $renderer
	 * @param \CakeDto\Console\Io $io
	 */
	public function __construct(Builder $builder, Renderer $renderer, Io $io) {
		$this->builder = $builder;
		$this->renderer = $renderer;
		$this->io = $io;
	}

	/**
	 * @param string $configPath
	 * @param string $srcPath
	 * @param array $options
	 * @return int Code
	 */
	public function generate($configPath, $srcPath, array $options = []) {
		$options += [
			'force' => false,
			'dryRun' => false,
			'confirm' => false,
		];

		$definitions = [];
		try {
			$definitions = $this->builder->build($configPath, $options);
		} catch (Exception $e) {
			$this->io->abort($e->getMessage());
		}

		$dtos = $this->generateDtos($definitions);
		$foundDtos = [];
		if (!$options['force']) {
			$foundDtos = $this->findExistingDtos($srcPath . 'Dto' . DS);
		}

		$returnCode = static::CODE_SUCCESS;
		$changes = 0;
		foreach ($dtos as $name => $content) {
			$isNew = !isset($foundDtos[$name]);
			$isModified = !$isNew && $this->isModified($foundDtos[$name], $content);

			if (!$isNew && !$isModified) {
				unset($foundDtos[$name]);
				$this->io->out('Skipping: ' . $name . ' DTO', 1, Shell::VERBOSE);
				continue;
			}

			$target = $srcPath . 'Dto' . DS . $name . 'Dto.php';
			$targetPath = dirname($target);
			if (!is_dir($targetPath)) {
				mkdir($targetPath, 0700, true);
			}

			if ($isModified) {
				$this->io->out('Changes in ' . $name . ' DTO:', 1, Shell::VERBOSE);
				$oldContent = file_get_contents($foundDtos[$name]);
				$this->_displayDiff($oldContent, $content);
			}
			if (!$options['dryRun']) {
				file_put_contents($target, $content);
				if ($options['confirm'] && !$this->checkPhpFileSyntax($target)) {
					$returnCode = static::CODE_ERROR;
				}
			}
			$changes++;

			unset($foundDtos[$name]);
			$this->io->success(($isModified ? 'Modifying' : 'Creating') . ': ' . $name . ' DTO');
		}

		foreach ($foundDtos as $name => $file) {
			if (!$options['dryRun']) {
				unlink($file);
			}
			$this->io->success('Deleting: ' . $name . ' DTO');
		}

		if ($returnCode === static::CODE_ERROR) {
			return $returnCode;
		}

		return $changes ? static::CODE_CHANGES : static::CODE_SUCCESS;
	}

	/**
	 * @param string $path
	 *
	 * @return string[]
	 */
	protected function findExistingDtos($path) {
		if (!is_dir($path)) {
			mkdir($path, 0700, true);
		}

		$files = [];

		$directory = new RecursiveDirectoryIterator($path);
		$iterator = new RecursiveIteratorIterator($directory);
		foreach ($iterator as $fileInfo) {

			$file = $fileInfo->getPathname();
			if (!preg_match('#src/Dto/(\w+/\w+|\w+)Dto\.php$#', $file, $matches)) {
				continue;
			}
			$name = $matches[1];
			$files[$name] = $file;
		}

		return $files;
	}

	/**
	 * @param string $file
	 * @param string $newContent
	 *
	 * @return bool
	 */
	protected function isModified($file, $newContent) {
		return file_get_contents($file) !== $newContent;
	}

	/**
	 * @param array $definitions
	 *
	 * @return string[]
	 */
	protected function generateDtos(array $definitions) {
		$dtos = [];
		foreach ($definitions as $name => $dto) {
			$this->renderer->set($dto);

			$content = $this->renderer->generate('dto');
			$dtos[$name] = $content;
		}

		return $dtos;
	}

	/**
	 * @param string $file
	 * @return bool
	 */
	protected function checkPhpFileSyntax($file) {
		exec('php -l "' . $file . '"', $output, $returnValue);

		if ($returnValue !== static::CODE_SUCCESS) {
			$this->io->err('PHP file invalid: ' . implode("\n", $output));
			return false;
		}

		return true;
	}

}
