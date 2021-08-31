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
    <Message v-if="existsData" severity="warn" :life="5000" :sticky="false">No existen Negociaciones ingresadas</Message>
    <div v-for="talk in dataTalks.data">
        <Fieldset :toggleable="true" :collapsed="false" class="left">
            <template #legend>
                <div style="color: #0059ff">{{talk.name}} </div>
                <div style="font-size:10px !important;">&nbsp;&nbsp;Fecha: &nbsp;</div>
                <div style="color: #0059ff">{{moment.utc(talk.date_entered).tz('America/Guayaquil').format('LL LT')}}</div>
                <div style="font-size:10px !important;">&nbsp;Estado: &nbsp;</div>
                <div style="color: #0059ff">{{status_talks[talk.estado_negociacion]}}</div>
                <div style="font-size:10px !important;">&nbsp;Etapa Venta: &nbsp;</div>
                <div style="color: #0059ff"> {{status_sales[talk.estado_venta]}}</div>
            </template>
            <Timeline :value="talk.history" class="customized-timeline">
                <template #marker="slotProps">
                        <span class="custom-marker p-shadow-2" :style="{backgroundColor:  slotProps.item.background}">
                             {{slotProps.item.label}}
                        </span>
                </template>
                <template #content="slotProps">
                    <Card>
                        <template #content>
                            <div v-if="slotProps.item.type !== 'call'" >
                                <div :style="{color:  slotProps.item.background}" class="text-10 block-inline">{{slotProps.item.name}} </div>
                                <div class="text-10 block-inline">
                                    &nbsp; Fecha:&nbsp;
                                </div>
                                <div :style="{color:  slotProps.item.background}" class="text-11 block-inline">
                                    {{moment.utc(slotProps.item.date_entered).tz('America/Guayaquil').format('LL LT')}}
                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'traffic'">
                                <div  class="text-10 block-inline">
                                    &nbsp; Estado:&nbsp;
                                </div>
                                <div  class="text-11 block-inline">
                                    {{status_traffic[slotProps.item.estado]}}
                                </div>
                                <div  class="text-10 block-inline">
                                    &nbsp; Revisado:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{status_revision[slotProps.item.revisado]}}
                                </div>
                                <div  class="text-10 block-inline">
                                    &nbsp; Fecha revisado:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{moment.utc(slotProps.item.fecha_revisado).tz('America/Guayaquil').format('LL LT')}}
                                </div>
                                <div>

                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'traffic'">
                                <div  class="text-10 block-inline">
                                    &nbsp; Tiempo de atención:&nbsp;
                                </div>
                                <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.tiempo_atencion}} min.
                                </div>
                                <div  class="text-10 block-inline">
                                      Agencia:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.agency.name}}
                                </div>
                                <div  class="text-10 block-inline">
                                    &nbsp; Asesor Comercial:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.user.first_name}} {{slotProps.item.user.last_name}}
                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'traffic'">
                                <div>
                                    <div  class="text-10 block-inline">
                                        &nbsp; ¿Cotizó?:&nbsp;
                                    </div>
                                    <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                        {{slotProps.item.cotizo}}
                                    </div>
                                </div>
                                <div>
                                    <div  class="text-10 block-inline">
                                        &nbsp; ¿Generó Hoja de Opciones?:&nbsp;
                                    </div>
                                    <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                        {{slotProps.item.genero_hoja_opciones}}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-10 block-inline">
                                        &nbsp; ¿LLenó Solicitud de Crédito?:&nbsp;
                                    </div>
                                    <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                        {{slotProps.item.solicito_credito}}
                                    </div>
                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'call'">
                                <div v-if="slotProps.item.type === 'call'" style="color: #0466c2" class="text-11 block-inline">
                                    Llamada {{calls_direction[slotProps.item.direction]}}
                                </div>
                                <div class="text-10 block-inline">
                                    &nbsp; Fecha Inicio:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{moment.utc(slotProps.item.date_start).tz('America/Guayaquil').format('LL LT')}}
                                </div>
                                <div class="text-10 block-inline">
                                    &nbsp; Fecha Fin:&nbsp;
                                </div>
                                <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{moment.utc(slotProps.item.date_end).tz('America/Guayaquil').format('LL LT')}}
                                </div>
                                <div class="text-10 block-inline">
                                    &nbsp; Duración: &nbsp;
                                </div>
                                <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    0{{slotProps.item.duration_hours}}:{{slotProps.item.duration_minutes}}
                                </div>
                            </div>
                            <div class="text-10"  v-if="slotProps.item.type === 'opportunity'">
                                <div  class="text-10 block-inline">
                                    &nbsp; Fecha de Cotización:&nbsp;
                                </div>
                                <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{moment.utc(slotProps.item.fecha_cotizacion_c).tz('America/Guayaquil').format('LL')}}
                                </div><br>
                                <div  class="text-10 block-inline">
                                    &nbsp; Agencia:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.agency.name}}
                                </div><br>
                                <div  class="text-10 block-inline">
                                    &nbsp; Linea de Negocio:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.business_line.name}}
                                </div><br>
                                <div  class="text-10 block-inline">
                                    &nbsp; Etapa de ventas:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.sales_stage}}
                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'opportunity'">
                                <div  class="text-10">
                                    &nbsp; Valor de Entrada:&nbsp;<span class="text-11" :style="{color:  slotProps.item.background}">
                                      ${{Math.ceil(slotProps.item.valorentrada_c)}}
                                </span>
                                </div>
                                <div  class="text-10">
                                    &nbsp; Tipo de Financiera:&nbsp;<span class="text-11" :style="{color:  slotProps.item.background}"> {{slotProps.item.tipofinancieratext_c}}</span>
                                </div>
                                <div  class="text-10">
                                    &nbsp; Modelo:&nbsp;<span class="text-11" :style="{color:  slotProps.item.background}">{{slotProps.item.modelo_c}}</span>
                                </div>
                                <div  class="text-10">
                                    &nbsp; Anio:&nbsp;<span class="text-11" :style="{color:  slotProps.item.background}"> {{slotProps.item.anio_c}}</span>
                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'appraisal'">
                                <div  class="text-10 block-inline">
                                    &nbsp; Estado Técnico:&nbsp;
                                </div>
                                <div  class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.estadotecnico}}
                                </div>
                                <div  class="text-10 block-inline">
                                    &nbsp; Fecha Solicitud Técnico:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{moment.utc(slotProps.item.fechasolicitudtecnico).tz('America/Guayaquil').format('LL')}}
                                </div>
                            </div>
                            <div class="text-10" v-if="slotProps.item.type === 'appraisal'">
                                <div  class="text-10 block-inline">
                                    &nbsp; Fecha Avalúo Técnico:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{moment.utc(slotProps.item.fechaavaluotecnico).tz('America/Guayaquil').format('LL')}}
                                </div>
                                <div  class="text-10 block-inline">
                                    &nbsp; Número Avalúo Técnico:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.numavaluo}}
                                </div>
                            </div>
                            <div class="text-10"  v-if="slotProps.item.type === 'appraisal'">
                                <div  class="text-10 block-inline">
                                    &nbsp; Tipo:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    {{slotProps.item.tipo}}
                                </div>
                                <div  class="text-10 block-inline">
                                    &nbsp; Precio Cliente:&nbsp;
                                </div>
                                <div class="text-11 block-inline" :style="{color:  slotProps.item.background}">
                                    ${{Math.ceil(slotProps.item.preciocliente)}}
                                </div>
                            </div>
                            <div>
                                <div class="text-10" v-if="slotProps.item.description !== null">Descripción: {{slotProps.item.description}}&nbsp;</div>
                            </div>
                            <p></p>
                        </template>
                    </Card>
                </template>
            </Timeline>
        </Fieldset>
    </div>
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
        let dataTalks = reactive({data: ref([])});
        const existsData = ref(false);
        let loading = ref(true);

        const calls_direction = {
            'Inbound': 'Entrante',
            'Outbound': 'Saliente'
        }

        const status_traffic = {
            1: "Abierto",
            2: "Cerrado"
        };

        const status_sales = {
            New: "Nueva",
            Cotizado: "Cotizado",
            "Closed Won": "Ganado",
            "Closed Lost": "Perdido"
        };

        const status_talks = {
            1: "Abierto",
            2: "Cerrado"
        };

        const status_revision = {
            S: "SI",
            N: "NO"
        };

        const addTypeElement = (object, type, background, label) => {
            return object.map(element => {
                element.type = type;
                element.background = background;
                element.label = label;
                return element;
            });

        }

        axios.get('/talksHistory/'+ numero_identificacion)
            .then(res => {
                dataTalks.data = res.data.talksHistory;
                if(dataTalks.data && dataTalks.data.length){
                    dataTalks.data.forEach(function(element, index) {
                        const traffics = addTypeElement(element.traffic, 'traffic', '#0859c4', 'Tr');
                        const calls = addTypeElement(element.calls, 'call', '#34d7e3', 'Cl');
                        const opportunities = addTypeElement(element.opportunities, 'opportunity', '#8f10c9', 'Co');
                        const appraisals = addTypeElement(element.appraisals, 'appraisal', '#89c408', 'Av');

                        dataTalks.data[index].history = traffics.concat(calls.concat(opportunities.concat(appraisals)));
                    });
                }
                existsData.value = dataTalks.data.length === 0 ? true : false;
                loading.value = false;
            }).catch(err => {
            console.log(err)
        })

        return {
            dataTalks,
            status_sales,
            status_talks,
            calls_direction,
            status_traffic,
            status_revision,
            loading,
            existsData,
            moment
        };
    }
}
</script>
<style>
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
</style>
