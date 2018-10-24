<template>
    <div class="min-h-full relative">
        <div class="flex w-full px-6 bg-white justify-between items-center">
            <div class="flex">
                <div class="py-6 border-b-4 px-1 border-red-light mr-8">
                    <h3 class="text-center font-sans font-light text-midnight text-lg">
                        Dashboard
                    </h3>
                </div>
                <!-- <div class="py-6">
                    <h3 class="">
                        <span class="inline-block mr-2">
                            <i class="fas fa-balance-scale"></i>
                        </span>
                        <span class="">0,0</span>
                        CFA
                    </h3>
                </div> -->
            </div>
            <div class="flex">
                <a href="#" @click.prevent="showServerForm = !showServerForm" class="text-white bg-midnight px-4 py-2 no-underline flex items-center justify-center rounded-full inline-block shadow-md">
                    <span class="inline-block mr-2">
                        <i class="fas fa-plus"></i>
                    </span>
                    New Server
                </a>
            </div>
        </div>
        <div class="flex py-8 flex-col items-center mb-4">
            <div class="w-4/5 bg-white shadow-md">
                <h2 class="text-leading font-normal text-midnight font-sans text-xl py-4 px-6">
                    Active Servers
                    <span class="inline-block border ml-2 text-white bg-blue p-1" v-text="total"></span>
                </h2>
                <table class="w-full">
                    <thead class="">
                        <tr class="bg-ghost-white w-full text-left">
                            <th class="py-4 px-4">Name</th>
                            <th class="py-4 px-4">Ip address</th>
                            <th class="py-4 px-4">Type</th>
                            <th class="py-4 px-4">Status</th>
                            <th class="py-4 px-4">Connection</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr class="" v-for="server in servers" class="hover:bg-yellow-lightest">
                            <td class="py-4 px-4">
                                <a :href="'/servers/' + server.id" class="text-blue-light no-underline font-sans text-base">
                                    <span class="">
                                        <i class="fas fa fa-server"></i>
                                    </span>
                                    <span class="" v-text="server.name">
                                    </span>
                                </a>
                            </td>
                            <td class="py-4 px-4" v-text="server.ip_address"></td>
                            <td class="py-4 px-4" v-text="server.service"></td>
                            <td class="py-4 px-4">
                                <span class="animate-rotate inline-block text-blue-light mr-2" v-if="server.status == 'provisioning'">
                                    <i class="far fa fa-sync"></i>
                                </span>
                                <span class="inline-block text-green-light mr-2" v-if="server.status == 'active'">
                                    <i class="far fa-check-circle"></i>
                                </span>
                                <span class="" v-text="server.status"></span>
                            </td>
                            <td class="py-4 px-4">Unknown</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex py-8 flex-col items-center">
            <div class="w-4/5 bg-white shadow-md">
                <h2 class="text-leading font-normal text-midnight font-sans text-xl py-4 px-6">Recent Events</h2>
                <table class="w-full">
                    <thead class="">
                        <tr class="bg-ghost-white w-full text-left">
                            <th class="py-4 px-4">Server</th>
                            <th class="py-4 px-4">Event</th>
                            <th class="py-4 px-4">When</th>
                            <th class="py-4 px-4">Output</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr class="" v-for="event in events" class="hover:bg-yellow-lightest font-light font-sans text-midnight">
                            <td class="py-4 px-4" v-text="event.server.name">
                            </td>
                            <td class="py-4 px-4" v-text="event.name"></td>
                            <td class="py-4 px-4" v-text="event.completed_at"></td>
                            <td class="py-4 px-4">N/A</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div :class="{'flex': showServerForm, 'hidden':!showServerForm}" class="w-full h-full items-center justify-center absolute pin-t" style="background-color: rgba(0,0,0,.385);">
            <div class="bg-white shadow-md w-3/5">
                <h2 class="border-b-2 border-pelorus rounded py-4 px-4 text-base text-left font-sans text-grey-darker font-normal mb-6">Add New Server</h2>
                <form action="/servers" method="POST" class="pb-8 z-0" @submit.prevent="createServer()">
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Server Name</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4">
                                    <input type="text" name="name" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" value="" v-model="form.name" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Public Ip Address</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4">
                                    <input type="text" name="ip_address" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" placeholder="48.78.10.11" v-model="form.ip_address" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Ram Size</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4">
                                    <input type="number" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" name="ram_size" value="1" v-model="form.ram_size"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">SSH Port <span class="text-grey-dark">(1000 - 9999)</span></label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4">
                                    <input type="number" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" name="ssh_port" value="22" v-model="form.ssh_port"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-grey-light pb-6">
                        <div class="flex w-full px-4 items-center">
                            <label for="" class="text-midnight w-1/3">Database Root Password</label>
                            <div class="w-full">
                                <div class="flex border-b-2 ml-4 bg-grey-lightest text-midnight py-1 flex-auto px-4">
                                    <input type="text" class="w-full appearance-none text-xl bg-transparent outline-none" autocomplete="false" name="database_root_password" placeholder="Optional" v-model="form.database_root_password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" px-4 flex justify-between pt-6">
                        <button class="bg-teal rounded-lg text-white text-sm py-3 px-4" type="submit" v-text="serverButtonText"></button>
                        <button class="rounded-lg text-grey-dark text-sm py-3 px-4 focus:outline-none" type="reset" @click.prevent="showServerForm = !showServerForm">Annuler</button>
                    </div>
                </form>
            </div>
        </div>

        <div :class="{'flex': showModalInfo, 'hidden':!showModalInfo}" class="absolute pin-l pin-t w-full h-full items-center justify-center" style="background: rgba(0, 0, 0, .325);">
            <div class="w-4/5 bg-white shadow-md relative">
                <h2 class="border-b border-pelorus rounded py-4 px-4 text-base text-left font-sans text-grey-darker font-normal">Provision Custom VPS</h2>
                <div class="px-4 py-6">
                    <p class="block mb-6">
                        Almost there! Here is your server's provision command and database root password. You should SSH into your server as <strong>root</strong> and run the command in your terminal. This command will begin the provisioning process for your server, and will configure the server so that it can be managed by Cepheus.
                    </p>

                    <div class="text-grey-darker mb-8">
                        <h3 class="mb-2">Provision Command</h3>
                        <p class="px-4 py-2 border border-grey-darker bg-gray-lighter text-gray text-sm word-break font-light font-sans words-break-all leading-normal" v-text="provisioning_link">
                        </p>
                    </div>
                    <div class="text-grey-darker mb-6">
                        <h3 class="mb-2">Database Password</h3>
                        <p class="px-4 py-2 border border-grey-darker bg-gray-lighter text-gray text-sm word-break font-light font-sans words-break-all leading-normal" v-text="database_password">
                        </p>
                    </div>
                </div>
                <a href="#" @click.prevent="showModalInfo = !showModalInfo" class="absolute button pin-b-tail rounded-full px-4 py-3 bg-white shadow-md hover:shadow-lg mt-2 pin-r no-underline text-grey-dark inline-block">&times;</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['userId'],
        data(){
            return {
                serverButtonText: 'Create Server',
                form: {
                    name: '',
                    ip_address: '',
                    database_root_password: '',
                    ssh_port: 22,
                    ram_size: 1
                },
                servers: [],
                events: [],
                showServerForm: false,
                database_password: '',
                provisioning_link: '',
                showModalInfo: false,
            }
        },
        mounted() {
            this.fetchServers();
            this.fetchEvents();
            this.form.name = window.rand_name();

            console.log(`Cepheus.User.${this.userId}`);

            Echo.private(`Cepheus.User.${this.userId}`)
            .listen('.server.provisioned', (e) => {
                console.log(e);
                this.fetchServers();
                this.fetchEvents();
            });
        },
        computed: {
            total() {
                return this.servers.length;
            }
        },
        methods: {
            fetchServers(){
                axios.get("/api/servers").then(({data}) => {
                    this.servers = data;
                })
            },
            fetchEvents(){
                axios.get("/api/events").then(({data}) => {
                    this.events = data;
                })
            },
            createServer(){
                this.serverButtonText = "Creating Server";
                axios.post("/api/servers", this.form).then(({data}) => {
                    console.log(data);
                    this.serverButtonText = "Create Server";
                    this.showServerForm = false;
                    this.provisioning_link = data.provisioning_link;
                    this.database_password = data.database_password;
                    this.showModalInfo = true;
                    this.form.name = window.rand_name();
                    this.fetchServers();
                })
            }
        }
    }
</script>
