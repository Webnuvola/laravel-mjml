<?php

namespace Asahasrabuddhe\LaravelMJML\Process;

use Html2Text\Html2Text;
use Illuminate\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MJML
{
    /**
     * @var Process
     */
    protected $process;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var string
     */
    protected $renderPath;

    /**
     * @var string
     */
    protected $compiledPath;

    /**
     * MJML constructor.
     *
     * @param View $view
     */
    public function __construct($view)
    {
        $this->view = $view;
    }

    /**
     * Build the mjml command.
     *
     * @return string
     */
    public function buildCmdLineFromConfig()
    {
        return implode(' ', [
            config('mjml.auto_detect_path') ? $this->detectBinaryPath() : config('mjml.path_to_binary'),
            $this->renderPath,
            '-o',
            $this->compiledPath,
        ]);
    }

    /**
     * Render the html content.
     *
     * @return HtmlString
     *
     * @throws \Throwable
     */
    public function renderHTML()
    {
        if (! $this->compiledPath) {
            $this->renderPath = tempnam(sys_get_temp_dir(), 'mjml_render_');
            $this->compiledPath = tempnam(sys_get_temp_dir(), 'mjml_compiled_');

            File::put($this->renderPath, $this->view->render());

            $this->process = Process::fromShellCommandline($this->buildCmdLineFromConfig());
            $this->process->run();

            if (! $this->process->isSuccessful()) {
                throw new ProcessFailedException($this->process);
            }
        }

        return new HtmlString(File::get($this->compiledPath));
    }

    /**
     * Render the text content.
     *
     * @return HtmlString
     *
     */
    public function renderText()
    {
        return new HtmlString(preg_replace("/[\r\n]{2,}/", "\n\n", (new Html2Text($content))->getText()));
    }

    /**
     * Detect the path to the mjml executable.
     *
     * @return string
     */
    public function detectBinaryPath()
    {
        return base_path('node_modules/.bin/mjml');
    }
}
