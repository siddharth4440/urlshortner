<!-- Stored in resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="p-4 sm:ml-64">

        <!-- Button to open the create/edit modal -->
        @can('create url')
            <div class="">
                <button id="open-create-url" type="button"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">New
                    url</button>
            </div>
        @endcan

        <div class="relative overflow-x-auto bg-white shadow-xs rounded-base border border-default">

            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="bg-neutral-secondary-soft border-b border-default">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            url
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            short url
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($urls->isEmpty())
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-body">
                                No URLs found.
                            </td>
                        </tr>
                    @else
                        @foreach ($urls as $url)
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                                <td scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $url->destination_url }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $url->default_short_url }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-fg-brand hover:underline open-url-modal"
                                        data-id="{{ $url->id }}" data-destinationUrl="{{ $url->destination_url }}"
                                        data-defaultShortUrl="{{ $url->default_short_url }}">Edit</a>
                                    <form action="{{ route('urls.destroy', $url->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-fg-brand hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
            {{ $urls->links('vendor.pagination.tailwind') }}
        </div>

        <!-- Create / Edit Company Modal -->
        <div id="url-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/50" id="url-modal-backdrop"></div>

            <div class="bg-white rounded-base shadow-lg max-w-lg w-full mx-auto z-10 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="url-modal-title" class="text-lg font-medium text-heading">Create Company</h3>
                    <button type="button" id="url-modal-close" class="text-body hover:text-heading">✕</button>
                </div>

                <form id="url-form" method="POST" action="{{ route('urls.store') }}">
                    @csrf
                    <input type="hidden" id="url-id" name="id" value="" />
                    <!-- method input will be given name "_method" for PATCH when editing -->
                    <input type="hidden" id="url-method" value="" />

                    <div class="mb-4">
                        <label for="url" class="block mb-2 text-sm font-medium text-body">url</label>
                        <input type="text" id="url" name="url"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="url required" />
                    </div>
                    <div class="mb-4" id="shortUrl" hidden>
                        <label for="short-url" class="block mb-2 text-sm font-medium text-body">short-url</label>
                        <input type="text" disabled id="short-url" name="short-url"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="short-url required" />
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" id="url-cancel"
                            class="text-body px-4 py-2 rounded-base border">Cancel</button>
                        <button type="submit" id="url-submit"
                            class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            (function () {
                const modal = document.getElementById('url-modal');
                const backdrop = document.getElementById('url-modal-backdrop');
                const closeBtn = document.getElementById('url-modal-close');
                const cancelBtn = document.getElementById('url-cancel');
                const openCreateBtn = document.getElementById('open-create-url');
                const companyForm = document.getElementById('url-form');
                const urlInput = document.getElementById('url');
                const shortUrlInput = document.getElementById('short-url');
                const idInput = document.getElementById('url-id');
                const methodInput = document.getElementById('url-method');
                const submitBtn = document.getElementById('url-submit');
                const modalTitle = document.getElementById('url-modal-title');
                const shortUrl = document.getElementById('shortUrl');


                function openModal(mode, urlData) {
                    if (mode === 'create') {
                        modalTitle.textContent = 'Create url';
                        submitBtn.textContent = 'Create';
                        urlInput.value = '';
                        shortUrl.hidden = true;
                    } else if (mode === 'edit') {
                        modalTitle.textContent = 'Edit url';
                        submitBtn.textContent = 'Save changes';
                        urlInput.value = urlData.url || '';
                        shortUrlInput.value = urlData.shortUrl || '';
                        shortUrl.hidden = false;
                        idInput.value = urlData.id || '';
                    }

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }

                function closeModal() {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }

                // wire buttons
                openCreateBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    openModal('create');
                });

                closeBtn.addEventListener('click', closeModal);
                cancelBtn.addEventListener('click', closeModal);
                backdrop.addEventListener('click', closeModal);

                // wire edit links
                document.querySelectorAll('.open-url-modal').forEach(function (el) {
                    el.addEventListener('click', function (e) {
                        e.preventDefault();
                        const id = this.dataset.id;
                        const url = this.dataset.destinationurl;
                        const shortUrl = this.dataset.defaultshorturl || '';
                        console.log(this.dataset);

                        openModal('edit', { id: id, url: url, shortUrl: shortUrl });
                    });
                });
            })();
        </script>
    </div>
@endsection