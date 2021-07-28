<template>
    <div>
        <div class="card">
            <DataTable :value="dataCarMatch.data" :paginator="true" class="p-datatable-customers" showGridlines :rows="7" ref="dt"
                       paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"

                       dataKey="id" v-model:filters="filters" filterDisplay="row" :loading="loading" responsiveLayout="scroll"
                       currentPageReportTemplate="Mostrando {first} to {last} of {totalRecords}"
                       :rowsPerPageOptions="[7,15,20,30,50]"
                       :globalFilterFields="['marca','modelo', 'color', 'anio', 'recorrido', 'provinciaPlaca', 'ciudadAnuncio', 'nombreDuenio']">
                <template #header>
                    <div class="p-d-flex p-jc-end">
                        <span class="p-input-icon-left ">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                            <Button icon="pi pi-external-link" label="Export" @click="exportCSV($event)" />
                        </span>
                    </div>
                </template>
                <template #empty>
                    Data no encontrada.
                </template>
                <template #loading>
                    Cargando data. Por favor espere.
                </template>
                <Column field="publicacionId" header="Publicacion Id"></Column>
                <Column field="scoreTotal" header="Score" :sortable="true"></Column>
                <Column field="marca" header="Marca"></Column>
                <Column field="modelo" header="Modelo"></Column>
                <Column field="color" header="Color"></Column>
                <Column field="precio" header="Precio" :sortable="true">
                    <template #body="slotProps">
                        {{formatCurrency(slotProps.data.precio)}}
                    </template>
                </Column>
                <Column field="anio" header="Año" :sortable="true"></Column>
                <Column field="recorrido" header="Recorrido" :sortable="true"></Column>
                <Column field="provinciaPlaca" header="Provincia Placa"></Column>
                <Column field="ultimoDigitoPlaca" header="Últ Díg Placa" :sortable="true"></Column>
                <Column field="fechaAnuncio" header="Fecha Anuncio" :sortable="true">
                    <template #body="slotProps">
                    {{moment.utc(slotProps.data.fechaAnuncio).tz('America/Guayaquil').format('YYYY-MM-DD')}}
                    </template>
                </Column>
                <Column field="ciudadAnuncio" header="Ciudad Anuncio"></Column>
                <Column field="nombreDuenio" header="Nombres Dueño"></Column>
                <Column field="urlWeb" header="Url Web" :sortable="true">
                    <template #body="slotProps">
                        <a :href="''+ slotProps.data.urlWeb +''" target="_blank">{{slotProps.data.urlWeb}}<slot/></a>
                    </template>
                </Column>
                <Column field="combustible" header="Combustible"></Column>
                <template #paginatorLeft>
                    <Button type="button" icon="pi pi-refresh" class="p-button-text" />
                </template>
                <template #paginatorRight>
                    <Button type="button" icon="pi pi-cloud" class="p-button-text" />
                </template>
            </DataTable>
        </div>
    </div>
</template>
<script>
import {ref, reactive, getCurrentInstance, onMounted} from 'vue';
import {FilterMatchMode} from 'primevue/api';

export default {
    name: 'App',
    props: {ticket_id: String},
    setup (props) {
        const ticket_id = props.ticket_id;
        onMounted(async() => {
           try{
             const res = await axios.get('/s3sCarMatch/'+ ticket_id);
             if(res.data.cars !== "Ticket Not Found"){
               dataCarMatch.data = res.data.cars;
             }
             loading.value = false;
           }catch(errors){
             console.log(errors);
           }

        })

        const moment = getCurrentInstance().appContext.config.globalProperties.$moment;
        let dataCarMatch = reactive({data: ref([])});
        let loading = ref(true);
        const dt = ref();
        const filters = ref({
            'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            'marca': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'modelo': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'color': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'precio': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'anio': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'recorrido': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'provinciaPlaca': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'ultimoDigitoPlaca': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'fechaAnuncio': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'ciudadAnuncio': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'nombreDuenio': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'urlWeb': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'combustible': {value: null, matchMode: FilterMatchMode.STARTS_WITH}
        });

        const exportCSV = () => {
            dt.value.exportCSV();
        };

        const formatCurrency = (value) => {
            return value.toLocaleString('en-US', {style: 'currency', currency: 'USD', minimumFractionDigits: 0,
                maximumFractionDigits: 0});
        };

        return {
            dataCarMatch,
            loading,
            filters,
            exportCSV,
            dt,
            formatCurrency,
            moment
        };
    }
}
</script>
<style scoped>
.p-datatable .p-datatable-tbody > tr > td{
    padding: 0.02rem 0.5rem !important;
}
.p-inputtext{
    padding-top: 0rem !important;
    padding-bottom: 0rem !important;
}
.p-button{
    padding-top: 0rem !important;
    padding-bottom: 0rem !important;
}
</style>
