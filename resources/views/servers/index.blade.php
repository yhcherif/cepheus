@extends("layouts.app")

@section("content")
<dashboard :user-id="{{auth()->id()}}"></dashboard>
{{-- <div class="min-h-full"> --}}
    {{-- @if(session("status"))
        <div class="flex w-full items-center justify-center pt-8">
            <div class="flex z-10">
                <div class="bg-blue-lightest border-t border-b border-blue text-blue-dark px-4 py-3" role="alert">
                  <p class="font-bold">Hey!</p>
                  <p class="text-sm">{{session("status")}}</p>
                </div>
            </div>
        </div>
    @endif --}}
    {{-- <div class="w-full pb-6 relative h-full pt-8">
        <div class="flex w-full h-full items-center justify-center">
            <div class="bg-white shadow-md w-3/5">
                <h2 class="border-b-2 border-pelorus rounded py-4 px-4 text-base text-left font-sans text-grey-darker font-normal mb-6">Add New Server</h2>
                <form action="{{ route('servers.store') }}" method="POST" class="pb-8 z-0">
                    @csrf
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Server Name</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('name') ? ' border-red' : 'border-grey' }}">
                                    <input type="text" name="name" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" value="{{old("name")}}" />
                                </div>
                                @if ($errors->has('name'))
                                    <p class="invalid-feedback mt-1 px-4">
                                        <strong class="text-red font-sans">{{ $errors->first('name') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Public Ip Address</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('ip_address') ? ' border-red' : 'border-grey' }}">
                                    <input type="text" name="ip_address" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" placeholder="48.78.10.11" value="{{old("ip_address")}}" />
                                </div>
                                @if ($errors->has('ip_address'))
                                    <p class="invalid-feedback mt-1 px-4">
                                        <strong class="text-red font-sans">{{ $errors->first('ip_address') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Ram Size</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('ram_size') ? ' border-red' : 'border-grey' }}">
                                    <input type="number" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" name="ram_size" value="{{old("ram_size") ?? '2'}}" />
                                </div>
                                @if ($errors->has('ram_size'))
                                    <p class="invalid-feedback mt-1 px-4">
                                        <strong class="text-red font-sans">{{ $errors->first('ram_size') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">SSH Port <span class="text-grey-dark">(1000 - 9999)</span></label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('ssh_port') ? ' border-red' : 'border-grey' }}">
                                    <input type="number" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" name="ssh_port" value="22" />
                                </div>
                                @if ($errors->has('ssh_port'))
                                    <p class="invalid-feedback mt-1 px-4">
                                        <strong class="text-red font-sans">{{ $errors->first('ssh_port') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-grey-light pb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Database Root Password</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4 {{ $errors->has('database_root_password') ? ' border-red' : 'border-grey' }}">
                                    <input type="text" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" name="database_root_password" value="{{old("database_root_password") ?? ''}}" placeholder="Optional" />
                                </div>
                                @if ($errors->has('database_root_password'))
                                    <p class="invalid-feedback mt-1 px-4">
                                        <strong class="text-red font-sans">{{ $errors->first('database_root_password') }}</p>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class=" px-4 flex justify-between pt-6">
                        <button class="bg-teal rounded-lg text-white text-sm py-3 px-4" type="submit">Create Server</button>
                        <button class="rounded-lg text-grey-dark text-sm py-3 px-4 focus:outline-none" type="reset" @click.prevent="resetForm()">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
{{-- </div> --}}
@stop
