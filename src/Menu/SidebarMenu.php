<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SidebarMenu
{
    private $factory;
    private $auth;

    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $auth)
    {
        $this->factory = $factory;
        $this->auth = $auth;
    }

    public function build(): ItemInterface
    {
        $menu = $this->factory->createItem('Главная', ['route' => 'home'])
            ->setChildrenAttributes(['class' => 'c-sidebar-nav']);

        $menu->addChild('Главная', ['route' => 'home'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        // $menu->addChild('Modal Dialog', ['uri' => '#'])
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
        //     // ->setExtra('routes', [
        //     //     ['route' => '_profiler_home'],
        //     //     ['pattern' => '/^_profiler_home\..+/']
        //     // ])
        //     ->setAttribute('class', 'c-sidebar-nav-item')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-link');

        // $menu->addChild('Конфигуратор')->setAttribute('class', 'c-sidebar-nav-title');
        // $menu->addChild('Контроль доступом', ['route' => '_profiler_home'])
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
        //     ->setAttribute('class', 'c-sidebar-nav-item')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-link');

        // $menu->addChild('Глоссарий', ['uri' => '#'])
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
        //     ->setAttribute('class', 'c-sidebar-nav-item')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-link');

        // $menu->addChild('Справочники', ['uri' => '#'])
        //     ->setAttribute('class', 'c-sidebar-nav-dropdown')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-dropdown-toggle')
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-puzzle')
        //     ->setChildrenAttribute('class', 'c-sidebar-nav-dropdown-items');

        // $menu['Справочники']->addChild('Списки', ['uri' => '#'])
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
        //     ->setAttribute('class', 'c-sidebar-nav-item')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-link');

        // $menu['Справочники']->addChild('Значения', ['uri' => '#'])
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
        //     ->setAttribute('class', 'c-sidebar-nav-item')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-link');


        // $menu->addChild('Документы', ['uri' => '#'])
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
        //     ->setAttribute('class', 'c-sidebar-nav-item')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-link');

        // $menu->addChild('Меню', ['uri' => '#'])
        //     ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
        //     ->setAttribute('class', 'c-sidebar-nav-item')
        //     ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('Образовательный процесс')->setAttribute('class', 'c-sidebar-nav-title');
        $menu->addChild('Учебные планы', ['route' => 'education_plan'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setExtra('routes', [
                ['route' => 'education_plan'],
                ['pattern' => '/^education_plan\..+/']
            ])            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('I. График образовательного процесса', ['uri' => '#'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('II. Сводные данные по бюджету времени', ['uri' => '#'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('III. План образовательного процесса', ['uri' => '#'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('IV. Учебные практики', ['uri' => '#'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('V. Производственные практики', ['uri' => '#'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');
            
        $menu->addChild('VI. Итоговая аттестация', ['uri' => '#'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('Календарь')->setAttribute('class', 'c-sidebar-nav-title');
        $menu->addChild('Список мероприятий', ['route' => 'calendar_editor.index'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');

        $menu->addChild('Адмнистрирование')->setAttribute('class', 'c-sidebar-nav-title');
        $menu->addChild('Учетные записи', ['route' => 'admin_users.list'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');
        $menu->addChild('Диаграммы', ['route' => 'diagram_editor.index'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');
        $menu->addChild('Глобальные переменные', ['route' => 'project_settings_manage_global'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');
        $menu->addChild('Локальные переменные для пользователя', ['route' => 'project_settings_manage_own'])
            ->setExtra('icon', 'c-sidebar-nav-icon cil-speedometer')
            ->setAttribute('class', 'c-sidebar-nav-item')
            ->setLinkAttribute('class', 'c-sidebar-nav-link');


        return $menu;
    }
}
