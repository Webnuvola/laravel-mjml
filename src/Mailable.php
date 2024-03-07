<?php

namespace Webnuvola\Laravel\Mjml;

use Html2Text\Html2Text;
use Illuminate\Mail\Mailable as IlluminateMailable;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Spatie\Mjml\Mjml;

/**
 * Mailable class.
 *
 * Inspired from asahasrabuddhe/laravel-mjml
 * @see https://github.com/asahasrabuddhe/laravel-mjml
 */
class Mailable extends IlluminateMailable
{
    /**
     * The MJML template for the message (if applicable).
     */
    protected ?string $mjml;

    /**
     * The MJML content for the message (if applicable).
     */
    protected ?string $mjmlContent = null;

    /**
     * Set the MJML template for the message.
     */
    public function mjml(string $view, array $data = []): static
    {
        $this->mjml = $view;
        $this->viewData = array_merge($this->buildViewData(), $data);

        return $this;
    }

    /**
     * Set the MJML content for the message.
     */
    public function mjmlContent(string $mjmlContent): static
    {
        $this->mjmlContent = $mjmlContent;

        return $this;
    }

    /**
     * Build the view for the message.
     *
     * @return array|string
     *
     * @throws \ReflectionException
     */
    protected function buildView()
    {
        if (isset($this->mjml) || isset($this->mjmlContent)) {
            return $this->buildMjmlView();
        }

        return parent::buildView();
    }

    /**
     * Build the MJML view for the message.
     */
    protected function buildMjmlView(): array
    {
        if (isset($this->mjml)) {
            $this->mjmlContent = View::make($this->mjml, $this->buildViewData());
        }

        $html = Mjml::new()->toHtml($this->mjmlContent);

        return [
            'html' => new HtmlString($html),
            'text' => new HtmlString(
                html_entity_decode(
                    preg_replace("/[\r\n]{2,}/", "\n\n", (new Html2Text($html, ['width' => 0]))->getText()),
                    ENT_QUOTES,
                    'UTF-8',
                ),
            ),
        ];
    }
}
