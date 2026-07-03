<?php

namespace App\Commons\Menu\Menus;

use App\Commons\Menu\Contracts\MenuDefinition;
use App\Commons\Menu\MenuBuilder;

class AdminMenu implements MenuDefinition
{
    public function items(): array
    {
        return [
            MenuBuilder::make('داشبورد')
                ->icon('ki-category')
                ->routeGroup(['dashboard'])
                ->route('dashboard')
                ->build(),

            MenuBuilder::make('مدیریت کاربران')
                ->icon('ki-user-edit')
                ->routeGroup(['users.*'])
                ->children([
                    MenuBuilder::make('لیست کاربران')
                        ->route('users.index')
                        ->build(),
                    MenuBuilder::make('کاربر جدید')
                        ->route('users.create')
                        ->build(),
                ])
                ->build(),

            MenuBuilder::make('شهرها')
                ->icon('ki-map')
                ->routeGroup(['cities.*', 'provinces.*'])
                ->children([
                    MenuBuilder::make('لیست شهرها')
                        ->route('cities.index')
                        ->build(),
                    MenuBuilder::make('شهر جدید')
                        ->route('cities.create')
                        ->build(),
                    MenuBuilder::make('استان جدید')
                        ->route('provinces.create')
                        ->build(),
                ])
                ->build(),

            MenuBuilder::make('سوالات نظر سنجی')
                ->icon('ki-glass')
                ->routeGroup(['questions.*'])
                ->children([
                    MenuBuilder::make('لیست سوالات')
                        ->route('questions.index')
                        ->build(),
                    MenuBuilder::make('سوال جدید')
                        ->route('questions.create')
                        ->build(),
                ])
                ->build(),
        ];
    }
}
