<?php

namespace App\Orchid\Screens\Client;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Service;
use App\Orchid\Layouts\Client\ClientListTable;
use Illuminate\Http\Request;
use Orchid\Alert\Toast;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Alert\Alert;
use Orchid\Screen\Fields\Select;

class ClientListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'clients' => Client::find(1),
            'clients' => Client::filters()->defaultSort('states', 'asc')->paginate(10),
        ];
    }

    public $description = "List of clients";

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Client List';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Create client')
                ->modal('createClientModal')
                ->method('create'),
            ModalToggle::make('Edit client')
                ->modal('editClient'),
        ];
    }

      /**
     * Create a new client.
     *
     * @param Request $request
     * @param Alert $alert
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * 
     * 
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [    
            ClientListTable::class,
            Layout::modal('createClientModal', Layout::rows([
                Input::make('phone')
                    ->required()
                    ->title('Phone')
                    ->mask('(999) 999-9999'),
                Group::make([
                    Input::make('name')
                        ->required()
                        ->title('Name'),
                    Input::make('last_name')
                        ->required()
                        ->title('Middle name'),
                ]),
                Input::make('email')
                    ->type('email')
                    ->title('Email'),
                DateTimer::make('birthday')
                    ->format('Y-m-d')
                    ->title('Date of birth'),
                Relation::make('service_id')
                    ->fromModel(Service::class, 'name')
                    ->title('Service')
                    ->required(),
                Select::make('assessment')
                    ->required()
                    ->options([
                        'Perfect'=>'Perfect',
                        'Good'=>'Good',
                        'Bad'=>'Bad',
                    ])    
            ]))->title('Create Client')->applyButton('Create'),

            Layout::modal('editClient', Layout::rows([
                Input::make('client.phone')
                    ->disabled()
                    ->required()
                    ->title('Phone'),
                Input::make('client.id')->type('hidden'),
                Group::make([
                    Input::make('client.name')
                        ->required()
                        ->placeholder('Client name')
                        ->title('Name'),
                    Input::make('client.last_name')
                        ->required()
                        ->placeholder('Client middle name')
                        ->title('Middle name'),
                ]),
                Input::make('client.email')
                    ->type('email')
                    ->placeholder('Client email')
                    ->title('Email'),
                DateTimer::make('client.birthday')
                    ->format('Y-m-d')
                    ->placeholder('Client date of birth')
                    ->title('Date of birth'),
                Relation::make('client.service_id')
                    ->fromModel(Service::class, 'name')
                    ->placeholder('Client service')
                    ->title('Service')
                    ->required(),
                Select::make('client.assessment')
                    ->required()
                    ->options([
                        'Perfect'=>'Perfect',
                        'Good'=>'Good',
                        'Bad'=>'Bad',
                    ])->empty('No service selected'),    
            ]))->async('asyncGetClient')

            
        ];
    }


    public function asyncGetClient(Client $client){
        return [
            'client' => $client
        ];
    }
    
    public function update(Request $request, Alert $alert){
        Client::find($request->input('client.id'))->update($request->client);
        
        $alert->info('updated successfully');
    }

    public function create(ClientRequest $request, Alert $alert)
    {
     

        Client::create(array_merge($request->validated(),[
            'states' => 'interviewed'
        ]));

        $alert->info('Client created successfully');
        return redirect()->back();
    }
    
}