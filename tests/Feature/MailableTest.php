<?php

use Webnuvola\Laravel\Mjml\Mailable;

class MjmlTestMail extends Mailable
{
    public function build(): void
    {
        $this->mjmlContent(
            <<<EOF
            <mjml>
                <mj-body>
                    <mj-section>
                        <mj-column>
                            <mj-text>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <p><a href="https://www.example.com/">Link</a></p>
                            </mj-text>
                        </mj-column>
                    </mj-section>
                </mj-body>
            </mjml>
            EOF,
        );
    }
}

it('can build email with inline content', function () {
    $mailable = new MjmlTestMail();

    $mailable
        ->assertSeeInOrderInHtml(
            [
                '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                '<p><a href="https://www.example.com/">Link</a></p>',
            ],
            false,
        )
        ->assertSeeInOrderInText([
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'Link [https://www.example.com/]',
        ]);
});
