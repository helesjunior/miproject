<?php

namespace App\Http\Controllers\Admin;

use App\Forms\UserForm;
use App\Forms\UserFormEdit;
use App\Models\User;
use App\Table\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Table $table)
    {
        $this->middleware('auth');
        $this->table = $table;

    }

    public function index()
    {
        $this->table
            ->model(User::class)
            ->columns([
                [
                    'label' => 'CPF / CNPJ',
                    'name' => 'cpfcnpj',
                    'order' => true //true, asc ou desc
                ],
                [
                    'label' => 'Nome',
                    'name' => 'name',
                    'order' => true //true, asc ou desc
                ],
                [
                    'label' => 'E-mail',
                    'name' => 'email',
                    'order' => true //true, asc ou desc
                ]

            ])
            ->filters([
                [
                    'name' => 'cpfcnpj',
                    'operator' => 'LIKE'
                ],
                [
                    'name' => 'name',
                    'operator' => 'LIKE'
                ],
                [
                    'name' => 'email',
                    'operator' => 'LIKE'
                ]
            ])
            ->addShowAction('admin.users.show')
            ->addEditAction('admin.users.edit')
            ->addDeleteAction('admin.users.destroy')
            //->addMoreAction([
            //    [
            //        'label' => 'Grupos',
            //        'route' => 'admin.users.create'
            //    ],
            //    [
            //        'label' => 'Unidades',
            //        'route' => 'admin.users.update'
            //    ]
            //])
            ->search();

        return view('adminlte::modules.admin.users.index', ['table' => $this->table]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = \FormBuilder::create(UserForm::class,[
            'url' => route('admin.users.store'),
            'method' => 'POST'
        ]);

        return view('adminlte::modules.admin.users.create',compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = \FormBuilder::create(UserForm::class);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $password = str_random(6);
        $data['password'] = $password;
        User::create($data);

        $request->session()->flash('message', 'Usuário criado com sucesso!');

        return redirect()->route('admin.users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('adminlte::modules.admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $form = \FormBuilder::create(UserFormEdit::class,[
            'url' => route('admin.users.update', [ 'user' => $user->id ]),
            'method' => 'PUT',
            'model' => $user
        ]);

        return view('adminlte::modules.admin.users.edit',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $form = \FormBuilder::create(UserFormEdit::class, [
            'data' => ['id' => $user->id]
        ]);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $user->update($data);
        session()->flash('message','Usuário editado com sucesso');

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('message','Usuário excluído com sucesso');
        return redirect()->route('admin.users.index');
    }
}
