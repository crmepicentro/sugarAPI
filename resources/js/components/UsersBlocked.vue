<template>
    <div>
        <Toast />
        <Toast position="top-left" group="tl" />
        <Toast position="bottom-left" group="bl" />
        <Toast position="bottom-right" group="br" />
    </div>
    <div>
        <div class="card">
            <DataTable :value="usersSugar" :paginator="true" showGridlines :rows="15" ref="dt"
                       editMode="row" v-model:editingRows="editingRows"
                       @rowEditInit="onRowEditInit" @rowEditCancel="onRowEditCancel" @rowEditSave="onRowEditComplete"
                       paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                       dataKey="id" v-model:filters="filters" filterDisplay="row" :loading="loading" responsiveLayout="scroll"
                       currentPageReportTemplate="Mostrando {first} to {last} of {totalRecords}"
                       :rowsPerPageOptions="[30,45,60,100]"
                       :globalFilterFields="['first_name','last_name','user_name','agencia']">
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
                <Column field="first_name" header="Nombres" :sortable="true"></Column>
                <Column field="last_name" header="Apellidos" :sortable="true"></Column>
                <Column field="phone_mobile" header="Celular" :sortable="true"></Column>
                <Column field="user_name" header="Username" :sortable="true"></Column>
                <Column field="agencia" header="Agencia" :sortable="true"></Column>
                <Column field="status" header="Status" >
                    <template #editor="slotProps">
                        <Dropdown v-model="slotProps.data['status']" :options="statuses" optionLabel="label" optionValue="value" placeholder="Seleccione el status">
                            <template #option="slotProps">
                                <span :class="'product-badge status-' + slotProps.option.value.toLowerCase()">{{slotProps.option.label}}</span>
                            </template>
                        </Dropdown>
                    </template>
                    <template #body="slotProps">
                        {{getStatusLabel(slotProps.data.status)}}
                    </template>
                </Column>
                <Column field="sources_blocked" header="Fuentes" >
                    <template #editor="slotProps">
                        <MultiSelect v-model="slotProps.data.sources_label_blocked" :options="fuenteMedios"
                                     optionLabel="label" optionGroupLabel="label" optionGroupChildren="items"
                                       display="chip"/>
                    </template>
                    <template #body="slotProps">
                        {{getSourcesLabel(slotProps.data.sources_label_blocked)}}
                    </template>
                </Column>
                <Column field="date_unblocked" header="Fecha Desbloqueo">
                    <template #editor="slotProps">
                        <Calendar id="date" v-model="slotProps.data[slotProps.column.props.field]" :showIcon="true" dateFormat="yy-mm-dd"  :showTime="false" />
                    </template>
                    <template #body="slotProps">
                        <div v-if="slotProps.data.date_unblocked">{{moment.utc(slotProps.data.date_unblocked).tz('America/Guayaquil').format('LL')}}</div>
                    </template>
                </Column>
                <Column :rowEditor="true" style="width: 10%; min-width:8rem" bodyStyle="text-align:center"></Column>
            </DataTable>
        </div>
    </div>
</template>
<script>
import {ref, reactive, getCurrentInstance, onMounted} from 'vue';
import { useToast } from "primevue/usetoast";
import {FilterMatchMode} from 'primevue/api';

export default {
    name: 'App',
    setup () {
        onMounted(async() => {
            try{
                const res = await axios.get('listComercialUsers');
                if(res.data.users !== "Asesores Not Found"){
                    usersSugar.value = res.data.users;
                }

                res.data.fuentes.forEach(fuente => fuenteMedios.value.push({label: fuente.nombre, code: fuente.id, items: getMedios(fuente.medios)}));

                loading.value = false;
            }catch(errors){
                console.log(errors);
            }
        })

        const getMedios = (medios) => {
            let mediosFuente = [];
            medios.forEach(medio => mediosFuente.push({label: medio.nombre, code: medio.id}));

            return mediosFuente;
        };

        const toast = useToast();
        const moment = getCurrentInstance().appContext.config.globalProperties.$moment;
        let usersSugar = ref(null);
        let fuenteMedios = ref([]);
        let loading = ref(true);
        const originalRows = ref({});
        const editingRows = ref([]);
        const statuses = ref([
            {label: 'Activo', value: 'active'},
            {label: 'Inactivo', value: 'inactive'}
        ]);

        const dt = ref();
        const filters = ref({
            'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            'first_name': {value: null, matchMode: FilterMatchMode.CONTAINS},
            'last_name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'user_name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            'agencia': {value: null, matchMode: FilterMatchMode.STARTS_WITH}
        });

        const onRowEditInit = (event) => {
            originalRows.value[event.index] = {...usersSugar.value[event.index]};

        };

        const onRowEditCancel = (event) => {
            usersSugar.value[event.index] = originalRows.value[event.index];
        };

        const getSourcesBlocked = (sourcesBlocked) => {
            let sources = [];

            if(typeof sourcesBlocked !== 'undefined') {
                sourcesBlocked.forEach((source) => {
                    sources.push(source.code);
                });

                return sources.toString();
            }

            return null;
        }

        const onRowEditComplete = async (user) => {
            try{
               const res = await axios.post('sugarUserBlocked', {
                    sugar_user_id: user.data.id,
                    date_unblocked: moment.utc(user.data.date_unblocked).tz('America/Guayaquil').format("YYYY-MM-DD").toString() || null,
                    status: user.data.status || 'active',
                    user_creation: 'admin',
                    user_modified: 'admin',
                    sources_blocked: getSourcesBlocked(user.data.sources_label_blocked) || getSourcesBlocked(fuenteMedios.value),
                    sugar_user_agency: user.data.agencia
                });

                toast.add({severity:'success', summary: 'Los datos han sido guardados', life: 3000});
            }catch(error){
                toast.add({severity:'error', summary: 'Error al guardar', life: 3000});
            }

        };

        const getStatusLabel = (status) => {
            switch(status) {
                case 'active':
                    return 'Activo';

                case 'inactive':
                    return 'Inactivo';

                default:
                    return 'Activo';
            }
        };

        const getSourcesLabel = (sources) => {
            let labelSources = [];

            if(Array.isArray(sources)) {
                sources.forEach(element => labelSources.push(element.label));

                return labelSources.join(",");
            }

            return sources;
        };

        const exportCSV = () => {
            dt.value.exportCSV();
        };

        return {
            statuses,
            getStatusLabel,
            getSourcesLabel,
            usersSugar,
            loading,
            filters,
            exportCSV,
            dt,
            moment,
            originalRows,
            onRowEditInit,
            onRowEditComplete,
            onRowEditCancel,
            editingRows,
            fuenteMedios
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
.p-component{
    font-size: 0.7rem !important;
}
p-link{
    font-size: 0.7rem !important;
}
.p-dropdown-item{
    font-size: 0.7rem !important;
}
.p-datepicker table{
    font-size: 0.7rem !important;
}

.p-inputtext{
    font-size: 0.7rem !important;
}

.p-paginator .p-paginator-pages .p-paginator-page{
    font-size: 0.7rem !important;
}
.p-datepicker table td > span{
    width: 1.5rem !important;
    height: 1.5rem !important;
}
.p-paginator .p-dropdown{
    height: 1.5rem !important;
}
</style>
