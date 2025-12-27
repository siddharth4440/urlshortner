<!-- Stored in resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="p-4 sm:ml-64">

<!-- Button to open the create/edit modal -->
<div class="max-w-sm mx-auto mb-6">
        <button id="open-create-user" type="button" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">New user</button>
</div>

        <div class="relative overflow-x-auto bg-white shadow-xs rounded-base border border-default">

            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="bg-neutral-secondary-soft border-b border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            user name
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Company name
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->isEmpty())
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-body">
                                No users found.
                            </td>
                        </tr>
                    @else
                        @foreach ($users as $user)
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                                <td scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $user->name }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $user->company->title ?? 'N/A' }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $user->email ?? 'N/A' }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $user->roles()->pluck('name') ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                    $user->role = $user->roles()->pluck('name')->first();
                                    @endphp
                                    <a href="#" class="font-medium text-fg-brand hover:underline open-user-modal" data-user="{{ $user }}">Edit</a>
                                </td>
                            </tr>
                    @endforeach
                    
                    @endif
                </tbody>
            </table>
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>

        <!-- Create / Edit Company Modal -->
        <div id="user-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/50" id="user-modal-backdrop"></div>

            <div class="bg-white rounded-base shadow-lg max-w-lg w-full mx-auto z-10 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="user-modal-title" class="text-lg font-medium text-heading">Create Company</h3>
                    <button type="button" id="user-modal-close" class="text-body hover:text-heading">✕</button>
                </div>

                <form id="user-form" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <input type="hidden" id="user-id" name="id" value="" />
                    <!-- method input will be given name "_method" for PATCH when editing -->
                    <input type="hidden" id="user-method" value="" />

                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-medium text-body">user name</label>
                        <input type="text" id="user-name" name="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="user name" required />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-body">user email</label>
                        <input type="email" id="user-email" name="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="user email" required />
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block mb-2 text-sm font-medium text-body">user password</label>
                        <input type="password" id="user-password" name="password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="user password" required />
                    </div>
                    <div class="mb-4">
                        <label for="Role" class="block mb-2 text-sm font-medium text-body">user Role</label>
                        @can('create admin')
                        <input type="radio" value="Admin" id="user-Role-admin" name="Role" class="" placeholder="user Role" required />Admin
                        @endcan
                        @can('create member')
                        <input type="radio" value="Member" id="user-Role-member" name="Role" class="" placeholder="user Role" required />Member
                        @endcan
                    </div>

                    <div class="mb-4">
                        <label for="company" class="block mb-2 text-sm font-medium text-body">Company</label>
                        <select id="user-company-id" name="company_id" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs">
                            <option value="">-- Select Company --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">
                                {{ $company->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" id="user-cancel" class="text-body px-4 py-2 rounded-base border">Cancel</button>
                        <button type="submit" id="user-submit" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            (function(){
                const createAdmin = {{ auth()->user()->can('create admin') }};
                const createMember ="{{ auth()->user()->can('create member') }}";
                const modal = document.getElementById('user-modal');
                const backdrop = document.getElementById('user-modal-backdrop');
                const closeBtn = document.getElementById('user-modal-close');
                const cancelBtn = document.getElementById('user-cancel');
                const openCreateBtn = document.getElementById('open-create-user');
                const nameInput = document.getElementById('user-name');
                const emailInput = document.getElementById('user-email');
                const roleInputAdmin = document.getElementById('user-Role-admin');
                const roleInputMember = document.getElementById('user-Role-member');
                const idInput = document.getElementById('user-id');
                const companySelect = document.getElementById('user-company-id');
                const methodInput = document.getElementById('user-method');
                const submitBtn = document.getElementById('user-submit');
                const modalTitle = document.getElementById('user-modal-title');


                function openModal(mode, user){
                    if(mode === 'create'){
                        modalTitle.textContent = 'Create user';
                        submitBtn.textContent = 'Create';
                        emailInput.value = '';
                        nameInput.value = '';
                        idInput.value = '';
                        if(createAdmin) { roleInputAdmin.checked = true;}
                        if(createMember) { roleInputMember.checked = true;}
                        if(companySelect) companySelect.value = '';
                        // remove _method name so it's a normal POST
                        methodInput.removeAttribute('name');
                        methodInput.value = '';
                    } else if(mode === 'edit'){
                        modalTitle.textContent = 'Edit user';
                        submitBtn.textContent = 'Save changes';
                        emailInput.value = user.email || '';
                        nameInput.value = user.name || '';
                        idInput.value = user.id;
                        (user.role == 'Admin') ? roleInputAdmin.checked = true : roleInputMember.checked = true;
                        if(companySelect) companySelect.value = user.company.id || '';
                    }

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }

                function closeModal(){
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }

                // wire buttons
                openCreateBtn.addEventListener('click', function(e){
                    e.preventDefault();
                    openModal('create');
                });

                closeBtn.addEventListener('click', closeModal);
                cancelBtn.addEventListener('click', closeModal);
                backdrop.addEventListener('click', closeModal);

                // wire edit links
                document.querySelectorAll('.open-user-modal').forEach(function(el){
                    el.addEventListener('click', function(e){
                        e.preventDefault();
                        const user = JSON.parse(this.dataset.user);
                        openModal('edit', user);
                    });
                });
            })();
        </script>
    </div>
@endsection