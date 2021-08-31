<template>
    <div>
        <Toast />
        <Toast position="top-left" group="tl" />
        <Toast position="bottom-left" group="bl" />
        <Toast position="bottom-right" group="br" />
    </div>
    <div align="center" v-if="loading">
        <ProgressSpinner style="width:50px;height:50px" strokeWidth="3" fill="#EEEEEE"/>
    </div>
    <Message v-if="existsData" severity="warn" :life="5000" :sticky="false">No existen Tickets ingresados</Message>
    <div v-for="ticket in dataTickets.data">
        <Fieldset :toggleable="true" :collapsed="false" class="left">
            <template #legend>
                <div class="title-color">{{ticket.name}} </div>
                <div class="text-10">&nbsp;&nbsp;Fecha: &nbsp;</div>
                <div class="title-color">
                    {{moment.utc(ticket.date_entered).tz('America/Guayaquil').format('LL LT')}}
                </div>
                <div class="text-10">&nbsp;Estado: &nbsp;</div>
                <div class="title-color">{{status_tickets[ticket.estado]}}</div>
            </template>
            <Timeline :value="ticket.history" class="customized-timeline">
                <template #marker="slotProps">
                        <span class="custom-marker p-shadow-2" :style="{backgroundColor:  slotProps.item.background}">
                             {{slotProps.item.label}}
                        </span>
                </template>
                <template #content="slotProps">
                    <Card>
                        <template #content>
                            <div class="text-10" v-if="slotProps.item.type !== 'call'" >
                                <div :style="{color:  slotProps.item.background}" class="text-10 block-inline">{{slotProps.item.name}} </div>
                                <div v-if="slotProps.item.type !== 'meeting'" class="text-10 block-inline">
                                    &nbsp;Fuente: &nbsp;
                                </div>
                                <div v-if="slotProps.item.type !== 'meeting'" :style="{color:  slotProps.item.background}" class="text-10 block-inline">
                                    {{sources[slotProps.item.fuente]}}
                                </div><br>
                                <div  class="text-10 block-inline">
                                    &nbsp; Fecha:&nbsp;
                                </div>
                                <div :style="{color:  slotProps.item.background}" class="text-10 block-inline">
                                    {{moment.utc(slotProps.item.date_entered).tz('America/Guayaquil').format('LL LT')}}
                                </div><br>
                                <div  v-if="slotProps.item.type === 'interaction'"  class="text-10 block-inline">
                                    &nbsp; Asesor BC:&nbsp;
                                </div>
                                <div v-if="slotProps.item.type === 'interaction'"  :style="{color:  slotProps.item.background}" class="text-10 block-inline">
                                    {{moment.utc(slotProps.item.date_entered).tz('America/Guayaquil').format('LL LT')}}
                                </div>
                                <div  v-if="slotProps.item.type === 'meeting'"  class="text-10 block-inline">
                                    &nbsp; Contacto:&nbsp;
                                </div>
                                <div v-if="slotProps.item.type === 'meeting'"  :style="{color:  slotProps.item.background}" class="text-10 block-inline">
                                    {{slotProps.item.contacts[0].first_name}}&nbsp;{{slotProps.item.contacts[0].last_name}}
                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'call'">
                                <div v-if="slotProps.item.type === 'call'"  class="calls-color">
                                    Llamada {{calls_direction[slotProps.item.direction]}}
                                </div>
                                <div class="text-10 block-inline">
                                    &nbsp; Fecha Inicio:&nbsp;
                                </div>
                                <div  class="calls-color">
                                    {{moment.utc(slotProps.item.date_start).tz('America/Guayaquil').format('LL LT')}}
                                </div>
                                <div class="text-10 block-inline">
                                    &nbsp; Fecha Fin:&nbsp;
                                </div>
                               <div class="calls-color">
                                   {{moment.utc(slotProps.item.date_end).tz('America/Guayaquil').format('LL LT')}}
                                </div>
                                <div class="text-10 block-inline">
                                    &nbsp; Duración: &nbsp;
                                </div>
                                <div class="calls-color">
                                    0{{slotProps.item.duration_hours}}:{{slotProps.item.duration_minutes}}
                                </div>
                            </div>
                            <div class="text-10">
                                <div class="text-10 block-inline" v-if="slotProps.item.description !== null" >Descripción: &nbsp;</div>
                                <div class="text-10 block-inline" v-if="slotProps.item.description !== null" :style="{color:  slotProps.item.background}">{{slotProps.item.description}}&nbsp;</div>
                                 <Button v-if="slotProps.item.type === 'interaction' && slotProps.item.fuente === 'inconcert'" label="Ver Chat" class="button-interaction p-button-text" @click="show_chat(slotProps.item.id)">Ver Chat</Button>
                                 <!--<Button v-if="slotProps.item.type === 'interaction' && slotProps.item.fuente !== 'inconcert'" label="Ver Chat" class="button-interaction p-button-text" @click="show_form(slotProps.item.id)">Ver Formulario</Button>-->
                            </div>
                            <p></p>
                        </template>
                    </Card>
                </template>
            </Timeline>
        </Fieldset>
    </div>
    <Dialog v-model:visible="displayModalChat"  :style="{width: '300vw'}">
        <template #header v-if="forms.messages.error">
            <b>No se encontró historial</b>
        </template>
        <template #header v-if="forms.messages.datos_adicionales">
            <b>Historial de Chat {{moment.unix(forms.messages.datos_adicionales.messages[0].msgtime).format("MM/DD/YYYY")}}</b>
        </template>
        <div v-if="forms.messages.datos_adicionales" v-for="field in forms.messages.datos_adicionales.messages" style="font-size: 12px">
            <div :style="{color: getColor(field.user_name)}">{{field.display_name || 'Bot'}} {{moment.unix(field.msgtime).format("hh:mm:ss")}}:</div>
            <div style="color:#5d6963">{{field.text}}</div>
        </div>
    </Dialog>
    <Dialog v-model:visible="displayModalForm">
        <div>
            <DataTable :value="forms.data.datos_adicionales.fields" responsiveLayout="scroll">
                <Column field="key" header="Campo"></Column>
                <Column field="nombre" header="Dato"></Column>
            </DataTable>
        </div>
        <template #header>
            <b>{{forms.data.datos_adicionales.title}}</b>
        </template>
    </Dialog>
</template>
<script>
import { ref, reactive } from 'vue';
import { useToast } from "primevue/usetoast";
import { getCurrentInstance } from 'vue'

export default {
    name: 'App',
    props: {numero_identificacion: String},
    setup(props) {
        const moment = getCurrentInstance().appContext.config.globalProperties.$moment;
        const toast = useToast();
        const numero_identificacion = props.numero_identificacion;
        const displayModalChat = ref(false);
        const displayModalForm = ref(false);
        const existsData = ref(false);
        let loading = ref(true);
        let dataTickets = reactive({data: ref([])});
        let forms = reactive({data: {}, messages: {}});
        const calls_direction = {
            'Inbound': 'Entrante',
            'Outbound': 'Saliente'
        }

        const sources = {
            inconcert: 'inConcert',
            tde: 'TDE',
            link: 'Formulario',
            acton: 'Acton',
            formulario: 'Formulario',
            facebook: 'Facebook',
            facebook_tde: 'Facebook TDE',
            jivochat: 'JivoChat',
        }

        const status_tickets = {
            1: "Nuevo",
            2: "No Contesta",
            4: "En Gestión",
            5: "Convertido a Prospecto",
            7: "Cerrado",
        };

        const addTypeElement = (object, type, background, label) =>  {
            return object.map(element => {
                element.type = type;
                element.background = background;
                element.label = label;
                return element;
            });
        }

        const getColor = (userId) => {
            if(userId) {
                const typeUser = userId.split('-');
                return typeUser.length > 2 ? '#1c04ba' : '#08a154';
            }

            return '#edae39';
        }

        axios.get('/ticketsHistory/'+ numero_identificacion)
            .then(res => {
                dataTickets.data = res.data.ticketHistory;
                if(dataTickets.data && dataTickets.data.length){
                    dataTickets.data.forEach((element, index) => {
                        const interactions = addTypeElement(element.interactions, 'interaction', '#f57514', 'IN');
                        const calls = addTypeElement(element.calls, 'call', '#06c3c9', 'Cl');
                        const meetings = addTypeElement(element.meetings, 'meeting', '#04cc29', 'Ci');
                        const prospeccion = addTypeElement(element.prospeccion, 'prospeccion', '#670399', 'Pr');

                        dataTickets.data[index].history = interactions.concat(calls.concat(meetings.concat(prospeccion)));
                    });
                }
                loading.value = false;
                existsData.value = dataTickets.data.length === 0 ? true : false;
            }).catch(err => {
            console.log(err)
        })

        const show_chat = (id) => {
            axios.get('/interactionChat/'+ id)
                .then(res => {
                    forms.messages = res.data;
                    displayModalChat.value = true;
                }).catch(err => {
                console.log(err)
                toast.add({severity:'error', summary: 'WebService inhabilitado', life: 3000});
            })
        }

        const show_form = (id) => {
            axios.get('/ticketsForms/'+ id)
                .then(res => {

                    forms.data = res.data;
                    console.log(forms.data);
                    displayModalForm.value = true;
                }).catch(err => {
                console.log(err)
                toast.add({severity:'warn', summary: 'Formulario no encontrado', life: 3000});
            })
        }

        return {
            dataTickets,
            status_tickets,
            calls_direction,
            displayModalChat,
            displayModalForm,
            show_chat,
            show_form,
            forms,
            existsData,
            loading,
            sources,
            moment,
            getColor
        };
    }
}
</script>
<style scoped>
#app {
    margin-top: 0px;
}

.text-10{
    font-size: 10px !important
}

.text-11{
    font-size: 11px !important
}
.block-inline{
    display:inline-block;
}

.p-timeline-event-opposite{
    flex: 0 !important;
}
.p-timeline-left .p-timeline-event-opposite{
    padding: 0px !important;
}

.p-card .p-card-body {
    padding: 0rem !important;
}

.p-card .p-card-content {
    padding: 0rem !important;
    padding-top: 0rem !important;
    padding-right: 0rem !important;
    padding-bottom: 0rem !important;
    padding-left: 1rem !important;
}

.p-fieldset-legend > a, .p-fieldset-legend > span{
    justify-content: right !important;
    font-size: 0.8rem !important;
    height: 0.5px !important;
}
.custom-marker {
    display: flex;
    width: 2rem;
    height: 2rem;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    border-radius: 50%;
    z-index: 1;
}
.p-datatable .p-datatable-thead > tr > th{
    padding: 0.2rem 0.2rem !important;
    font-size: 0.8rem !important;
}

.p-datatable .p-datatable-tbody > tr > td{
    padding: 0.2rem 0.2rem !important;
    font-size: 0.8rem !important;
}

.button-interaction{
    font-size:10px;
    padding: 0px
}
.calls-color{
    color: #06c3c9 !important;
    display:inline-block;
    font-size: 11px !important
}
.text-10{
    font-size: 10px !important
}
.block-inline{
    display:inline-block;
}
.title-color{
    color: #094dad !important;
}
.p-timeline-event-opposite{
    flex: 0 !important;
}
.p-timeline-left .p-timeline-event-opposite{
    padding: 0px !important;
}

.p-card .p-card-body {
    padding: 0rem !important;
}

.p-card .p-card-content {
    padding: 0rem !important;
    padding-top: 0rem !important;
    padding-right: 0rem !important;
    padding-bottom: 0rem !important;
    padding-left: 1rem !important;
}

.p-fieldset-legend > a, .p-fieldset-legend > span{
    justify-content: right !important;
    font-size: 0.8rem !important;
    height: 0.5px !important;
}
.custom-marker {
    display: flex;
    width: 2rem;
    height: 2rem;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    border-radius: 50%;
    z-index: 1;
}

.p-datatable .p-datatable-thead > tr > th{
  padding: 0.2rem 0.2rem !important;
  font-size: 0.8rem !important;
}

.p-datatable .p-datatable-tbody > tr > td{
  padding: 0.2rem 0.2rem !important;
  font-size: 0.8rem !important;
}

.p-fieldset .p-fieldset-content {
  padding: 0 0.5rem;
}

.p-timeline.p-timeline-vertical .p-timeline-event-opposite, .p-timeline.p-timeline-vertical .p-timeline-event-content {
  padding: 0 0.5rem;
}
</style>
