@extends("layouts.app")

@section("content")
<div class="min-h-full">
    <div class="flex w-full px-6 bg-white justify-between items-center">
        <div class="flex">
            <div class="py-6 border-b-4 px-1 border-red-light mr-8">
                <h3 class="text-center font-sans font-light text-midnight text-lg">
                    Nouvelle transaction
                </h3>
            </div>
            <div class="py-6">
                <h3 class="">
                    <span class="inline-block mr-2">
                        <i class="fas fa-balance-scale"></i>
                    </span>
                    <span class="">0,0</span>
                    CFA
                </h3>
            </div>
        </div>
        <div class="flex">
            <a href="#" class="text-white bg-midnight px-4 py-2 no-underline flex items-center justify-center rounded-full inline-block shadow-md">
                <span class="inline-block mr-2">
                    <i class="fas fa-plus"></i>
                </span>
                Ajouter des médicaments
            </a>
        </div>
    </div>
    @if(session("status"))
        <div class="flex w-full items-center justify-center pt-8">
            <div class="flex z-10">
                <div class="bg-blue-lightest border-t border-b border-blue text-blue-dark px-4 py-3" role="alert">
                  <p class="font-bold">Hey!</p>
                  <p class="text-sm">{{session("status")}}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="w-full pb-6 relative h-full pt-8 flex justify-center">
        <div class="w-2/3">
            <ul class="list-reset flex border-b">
              <li class="-mb-px mr-1">
                <a class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-dark font-semibold" href="#">Sites</a>
              </li>
              <li class="mr-1">
                <a class="bg-white inline-block py-2 px-4 text-blue hover:text-blue-darker font-semibold" href="#">SSH Keys</a>
              </li>
              <li class="mr-1">
                <a class="bg-white inline-block py-2 px-4 text-blue hover:text-blue-darker font-semibold" href="#">MySQL</a>
              </li>
              <li class="mr-1">
                <a class="bg-white inline-block py-2 px-4 text-blue hover:text-blue-darker font-semibold" href="#">PHP</a>
              </li>
              {{-- <li class="mr-1">
                <a class="bg-white inline-block py-2 px-4 text-grey-light font-semibold" href="#">Meta</a>
              </li> --}}
            </ul>
            <div class="w-full bg-white shadow">
                <h2 class="border-b border-green font-normal font-sans px-4 py-4">
                    New Site
                </h2>
                <div class="bg-gray-lighter py-6">
                    <div class="flex w-full justify-end pb-6 pr-6">
                        <div class="border bg-blue-lighter w-4/5 px-4 py-6 mb-4">
                            <p class="mb-4">
                                Think of sites as representing each "domain" on your server.
                            </p>
                            <p class="">
                                The "default" site is included with each freshly provisioned server; however, you should delete it and create a new site with a valid domain when you are ready to launch your production site. If you need to host additional domains or sub-domains,add them here.
                            </p>
                        </div>
                    </div>
                    <form action="#" method="POST" class="">
                        @csrf
                        <div class="mb-6">
                            <div class="flex w-full px-4 items-center">
                                <label for="" class="text-midnight w-1/3 text-right pr-4">Root Domain</label>
                                <div class="w-full">
                                    <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('domain') ? ' border-red' : 'border-grey' }}">
                                        <input type="text" name="domain" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" value="{{old("domain")}}" />
                                    </div>
                                    @if ($errors->has('domain'))
                                        <p class="invalid-feedback mt-1 px-4">
                                            <strong class="text-red font-sans">{{ $errors->first('domain') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="flex w-full px-4 items-center">
                                <label for="" class="text-midnight w-1/3 text-right pr-4">Project Type</label>
                                <div class="w-full">
                                    <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('project_type') ? ' border-red' : 'border-grey' }}">
                                        <input type="text" name="project_type" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" value="{{old("project_type")}}" />
                                    </div>
                                    @if ($errors->has('project_type'))
                                        <p class="invalid-feedback mt-1 px-4">
                                            <strong class="text-red font-sans">{{ $errors->first('project_type') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="flex w-full px-4 items-center">
                                <label for="" class="text-midnight w-1/3 text-right pr-4">Web Directory</label>
                                <div class="w-full">
                                    <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('web_directory') ? ' border-red' : 'border-grey' }}">
                                        <input type="text" name="web_directory" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" value="{{old("web_directory")}}" />
                                    </div>
                                    @if ($errors->has('web_directory'))
                                        <p class="invalid-feedback mt-1 px-4">
                                            <strong class="text-red font-sans">{{ $errors->first('web_directory') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="flex w-full px-4 items-center">
                                <label for="" class="text-midnight w-1/3 text-right pr-4"></label>
                                <div class="w-full px-4">
                                    <button class="bg-teal rounded-lg text-white text-sm py-3 px-4" type="submit">Add Site</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(request('showModal'))
        <div class="absolute pin-l pin-t w-full h-full flex items-center justify-center" style="background: rgba(0, 0, 0, .325);">
            <div class="w-4/5 bg-white shadow-md relative">
                <h2 class="border-b border-pelorus rounded py-4 px-4 text-base text-left font-sans text-grey-darker font-normal">Provision Custom VPS</h2>
                <div class="px-4 py-6">
                    <p class="block mb-6">
                        Almost there! Here is your server's provision command and database root password. You should SSH into your server as <strong>root</strong> and run the command in your terminal. This command will begin the provisioning process for your server, and will configure the server so that it can be managed by Cepheus.
                    </p>

                    <div class="text-grey-darker mb-8">
                        <h3 class="mb-2">Provision Command</h3>
                        <p class="px-4 py-2 border border-grey-darker bg-gray-lighter text-gray text-sm word-break font-light font-sans words-break-all leading-normal">
                            wget -O cepheus.sh "{{ route('provisioning.create', ['server' => $server, 'cepheus_token' => $server->token]) }}"; bash cepheus.sh
                        </p>
                    </div>
                    <div class="text-grey-darker mb-6">
                        <h3 class="mb-2">Database Password</h3>
                        <p class="px-4 py-2 border border-grey-darker bg-gray-lighter text-gray text-sm word-break font-light font-sans words-break-all leading-normal">
                            {{$server->database_root_password}}
                        </p>
                    </div>
                </div>
                <a href="{{ route('servers.sites', ['server' => $server]) }}" class="absolute button pin-b-tail rounded-full px-4 py-3 bg-white shadow-md hover:shadow-lg mt-2 pin-r no-underline text-grey-dark inline-block">&times;</a>
            </div>
        </div>
    @endif
</div>
@stop
