<?php

namespace App\Orchid\Layouts\Client;

use App\Models\Client;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClientListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'clients';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('phone', 'Phone'),
            TD::make('states', 'Status')->sort(),
            TD::make('name', 'Name'),
            TD::make('last_name', 'Middle name'),
            TD::make('email', 'Email'),
            TD::make('birthday', 'Date of birthday'),
            TD::make('assessment', 'Grade'),
            TD::make('created_at', 'Created')->render(function($client){
                return $client->created_at->format('M d, Y');
            }),
            TD::make('action')->render(function(Client $client){
                return ModalToggle::make('Edit')
                    ->modal('editClient')
                    ->method('update')
                    ->modalTitle('Edit client ' . $client->phone)
                    ->asyncParameters([
                        'client' => $client->id
                    ]);
            })
        ];
    }
}

