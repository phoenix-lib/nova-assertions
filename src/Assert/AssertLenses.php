<?php

namespace NovaTesting\Assert;

use NovaTesting\NovaResponse;

trait AssertLenses
{
    public $novaLensResponse;

    public function assertLensCount($amount)
    {
        $this->setNovaLensResponse();

        $this->novaLensResponse->assertJsonCount($amount);

        return $this;
    }

    public function assertLensesInclude($class)
    {
        $this->setNovaLensResponse();

        $this->novaLensResponse->assertJsonFragment([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function assertLensesExclude($class)
    {
        $this->setNovaLensResponse();

        $this->novaLensResponse->assertJsonMissing([
            'uriKey' => app($class)->uriKey()
        ]);

        return $this;
    }

    public function setNovaLensResponse()
    {
        if ($this->novaLensResponse) {
            return;
        }

        extract($this->novaParameters);

        $this->novaLensResponse = new NovaResponse(
            $this->parent->getJson("$endpoint/lenses"),
            $this->novaParameters,
            $this->parent
        );
    }
}