<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Helper\DateHelper;
use App\Model\Events;
use Nette;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function renderDefault()
    {
        $this->template->addFunction('formatCzechDate', [DateHelper::class, 'formatCzechDate']);
        $this->template->daysEvents = (new Events())->getDaysEvents();
    }
}
