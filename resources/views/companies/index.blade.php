<!-- Stored in resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="p-4 sm:ml-64">

<!-- Button to open the create/edit modal -->
<div class="max-w-sm mx-auto mb-6">
        <button id="open-create-company" type="button" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">New Company</button>
</div>

        <div class="relative overflow-x-auto bg-white shadow-xs rounded-base border border-default">

            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="bg-neutral-secondary-soft border-b border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Company name
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($companies->isEmpty())
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-body">
                                No companies found.
                            </td>
                        </tr>
                    @else
                        @foreach ($companies as $company)
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $company->title }}
                                </th>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-fg-brand hover:underline open-company-modal" data-id="{{ $company->id }}" data-name="{{ $company->title }}">Edit</a>
                                </td>
                            </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Create / Edit Company Modal -->
        <div id="company-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/50" id="company-modal-backdrop"></div>

            <div class="bg-white rounded-base shadow-lg max-w-lg w-full mx-auto z-10 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="company-modal-title" class="text-lg font-medium text-heading">Create Company</h3>
                    <button type="button" id="company-modal-close" class="text-body hover:text-heading">✕</button>
                </div>

                <form id="company-form" method="POST" action="{{ route('companies.store') }}">
                    @csrf
                    <input type="hidden" id="company-id" name="id" value="" />
                    <!-- method input will be given name "_method" for PATCH when editing -->
                    <input type="hidden" id="company-method" value="" />

                    <div class="mb-4">
                        <label for="company-name" class="block mb-2 text-sm font-medium text-body">Company name</label>
                        <input type="text" id="company-name" name="title" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="Company name" required />
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" id="company-cancel" class="text-body px-4 py-2 rounded-base border">Cancel</button>
                        <button type="submit" id="company-submit" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            (function(){
                const modal = document.getElementById('company-modal');
                const backdrop = document.getElementById('company-modal-backdrop');
                const closeBtn = document.getElementById('company-modal-close');
                const cancelBtn = document.getElementById('company-cancel');
                const openCreateBtn = document.getElementById('open-create-company');
                const companyForm = document.getElementById('company-form');
                const nameInput = document.getElementById('company-name');
                const idInput = document.getElementById('company-id');
                const methodInput = document.getElementById('company-method');
                const submitBtn = document.getElementById('company-submit');
                const modalTitle = document.getElementById('company-modal-title');

                const createUrl = "{{ route('companies.store') }}";
                const baseUpdateUrl = "{{ url('companies') }}"; // we'll append /{id}

                function openModal(mode, company){
                    if(mode === 'create'){
                        modalTitle.textContent = 'Create Company';
                        submitBtn.textContent = 'Create';
                        nameInput.value = '';
                        idInput.value = '';
                        // remove _method name so it's a normal POST
                        methodInput.removeAttribute('name');
                        methodInput.value = '';
                    } else if(mode === 'edit'){
                        modalTitle.textContent = 'Edit Company';
                        submitBtn.textContent = 'Save changes';
                        nameInput.value = company.name || '';
                        idInput.value = company.id;
                        // enable method spoofing for PATCH
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
                document.querySelectorAll('.open-company-modal').forEach(function(el){
                    el.addEventListener('click', function(e){
                        e.preventDefault();
                        const id = this.dataset.id;
                        const name = this.dataset.name;
                        openModal('edit', { id: id, name: name });
                    });
                });
            })();
        </script>
    </div>
@endsection