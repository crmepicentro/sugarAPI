<template>
    <div align="center" v-if="loading">
        <ProgressSpinner style="width:50px;height:50px" strokeWidth="3" fill="#EEEEEE"/>
    </div>
    <Message v-if="!clientExists" severity="warn" :life="5000" :sticky="false">No existe contacto creado.</Message>
    <Card v-if="!loading && clientExists">
        <template #title style="padding: 0px">
            <p class="title-client">{{dataClient.data.first_name}} {{dataClient.data.last_name}}</p>
        </template>
        <template #content style="padding: 0px">
            <form class="row g-4 text-12">
                <div class="col-auto text-12">
                    <label class="visually-hidden label-contact">Tipo Cliente</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="type_clients[dataClient.data.tipo_cliente_c]">
                </div>
                <div class="col-auto">
                    <label class="visually-hidden label-contact">Tipo de Contacto</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="type_contact[dataClient.data.tipo_contacto_c]">
                </div>
                <div class="col-auto">
                    <label class="visually-hidden label-contact">Tipo de Identificación</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="type_identification[dataClient.data.tipo_identificacion_c]">
                </div>
                <div class="col-auto">
                    <label class="visually-hidden label-contact">Número de Identificación</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="dataClient.data.numero_identificacion_c">
                </div>
            </form>
            <form class="row g-4  text-12">
                <div class="col-auto text-12">
                    <label class="visually-hidden label-contact">Nacionalidad</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="dataClient.data.nacionality">
                </div>
                <div class="col-auto">
                    <label class="visually-hidden label-contact">Cumpleaños</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="dataClient.data.birthdate">
                </div>
                <div class="col-auto">
                    <label class="visually-hidden label-contact">Móvil</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="dataClient.data.phone_mobile">
                </div>
                <div class="col-auto">
                    <label class="visually-hidden label-contact">Tel. Casa</label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="dataClient.data.phone_home">
                </div>
            </form>
            <form class="row g-4  text-12">
                <div class="col-auto text-12">
                    <label class="visually-hidden label-contact">Email: </label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="dataClient.data.email.email_address">
                </div>
                <div class="col-auto text-12">
                    <label class="visually-hidden label-contact">Estado Civil: </label>
                    <input type="text" readonly class="form-control-plaintext text-12 color-input" v-model="gender[dataClient.data.estado_civil_c]">
                </div>
            </form>
        </template>
    </Card>
</template>
<script>
import { ref } from 'vue';
import { reactive } from 'vue';
import { useToast } from "primevue/usetoast";

export default {
    name: 'App',
    props: ['numero_identificacion', 'ticket_id', 'modulo'],
    setup(props) {
        const numero_identificacion = props.numero_identificacion || props.ticket_id;
        let dataClient = reactive({data: ref([])});
        let clientExists = ref(true);
        let loading = ref(true);
        const type_clients = {
            '01': 'Persona Natural',
            '02': 'Empresa Privada',
            '03': 'Empresa Pública',
        };

        const type_contact = {
            1: 'Prospecto',
            2: 'Contacto',
            3: 'Cliente',
        };

        const type_identification = {
            'C': 'Cedula',
            'P': 'Pasaporte',
            'R': 'Contacto'
        };

        const gender = {
            'F': 'Femenino',
            'M': 'Masculino'
        };

        axios.get('/client/'+ numero_identificacion)
            .then(res => {
                dataClient.data = res.data.contact;

                if(res.data.contact === null){
                    clientExists.value = false;
                }

                loading.value = false;
            }).catch(err => {
            console.log(err)
        })

        return {
            dataClient,
            type_clients,
            type_contact,
            type_identification,
            loading,
            gender,
            clientExists
        };
    }
}
</script>
<style scoped>
.title-client{
    font-size: 12px;
    padding-left: 1rem !important;
}

.text-12{
  font-size: 12px !important
}

.color-input{
    color: #04328f !important
}

.label-contact{
  color: #6f7278;
  margin-bottom: 0rem !important;
}

.p-card .p-card-body {
    padding: 0rem !important;
    width: 95%;
}
</style>
