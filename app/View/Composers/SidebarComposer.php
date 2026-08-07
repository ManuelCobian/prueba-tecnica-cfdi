<?php

namespace App\View\Composers;

use App\Services\Sidebar\ItemGroup;
use App\Services\Sidebar\ItemHeader;
use App\Services\Sidebar\ItemLink;
use App\Services\Sidebar\ItemSideBar;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        $items = collect(config('siderbar'))->map(function ($item) {
            return $this->parseItem($item);
        });

        $items = $items->filter(function ($item) {
            return $item->authorize();
        });
        $view->with('sidebarItems', $items);
    }

    public function parseItem($item)
    {
        
        switch ($item['type']) {
            case "header":
                return new ItemHeader(
                    title: $item['title'],
                    can: $item['can'] ?? []
                );
            case "link":
                return new ItemLink(
                    title: $item['title'],
                    href: isset($item['route']) ? route($item['route']) : '#',
                    icon: $item['icon'] ?? 'fa-regular fa-circle',
                    active: isset($item['active']) ? request()->routeIs($item['active']) : false,
                    can: $item['can'] ?? []
                );
            case "group":
                $group = new ItemGroup(
                    title: $item['title'],
                    items: [],
                    active: $item['active'] ? request()->routeIs($item['active']) : false,
                    icon: $item['icon'] ?? 'fa-regular fa-circle',
                );
                foreach ($item['items'] as $subItem) {
                    $group->add($this->parseItem($subItem));
                }
                return $group;
            default:
                throw new \Exception("Tipo de item desconocido: {$item['type']}");
        }
    }
}
