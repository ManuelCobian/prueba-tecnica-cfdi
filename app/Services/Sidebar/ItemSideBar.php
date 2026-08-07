<?php 
namespace App\Services\Sidebar;
interface ItemSideBar {
    public function render(): string;
    public function authorize():bool;
}

