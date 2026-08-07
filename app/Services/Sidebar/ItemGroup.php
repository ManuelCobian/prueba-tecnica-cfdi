<?php

namespace App\Services\Sidebar;

class ItemGroup implements ItemSideBar
{
    protected string $title;
    protected array $items = [];
    protected string $active;
    protected string $icon;

    public function __construct(string $title, array $items, string $active, string $icon)
    {
        $this->title = $title;
        $this->items = $items;
        $this->active = $active;
        $this->icon = $icon;
    }

    public function add(ItemLink $item): self
    {
        $this->items[] = $item;
        return $this;
    }


    public function render(): string
    {
        $items = array_filter($this->items, function ($item) {
            return $item->authorize();
        });
        $html = view('sidebar.item-group', [
            'title' => $this->title,
            'items' => $items,
            'active' => $this->active,
            'icon' => $this->icon
        ])->render();
        return $html;
    }

    public function authorize(): bool
    {
        foreach ($this->items as $item) {
            if ($item->authorize()) {
                return true;
            }
        }

        return false;
    }
}
