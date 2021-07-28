
<template>
  <div>
    <Sidebar :visible="bandSend" :baseZIndex="1000" position="bottom" :showCloseIcon="false" style="height: 6em">
      <h5>
        <ProgressSpinner style="width:50px;height:50px" strokeWidth="2" fill="#EEEEEE" animationDuration=".5s"/>
        <span> Enviando información, espere... </span>
      </h5>
    </Sidebar>
    <Sidebar v-model:visible="sospechoso.band" :baseZIndex="1200" position="top" style="height: 10rem" :dismissable="false">
      <h5 class="text-center">
        <i class="pi pi-shield" style="font-size: 50px;"></i><br>
       <span >Advertencia!<br>
        Este Cliente ha sido marcado como {{sospechoso.text}}<br>
        *** Alertar al Coach ***</span>
      </h5>
    </Sidebar>
    <Sidebar v-model:visible="save" :baseZIndex="1200" position="bottom" style="height: 10rem" >
      <div class="text-center pb-2" style="border-bottom: 2px solid green">
        <h5 >
          <i class="pi pi-check" style="font-size: 50px;"></i><br>
          <span >Guardado Correctamente</span>
        </h5>
        <a :href="urlSugar" target="_blank">
          <Button label="Ver Prospecto - SUGAR" icon="pi pi-search" class="text-center p-button-success" />
        </a>
      </div>
    </Sidebar>
  </div>
  <div class="row no-gutters mb-4">
    <nav class="navbar navbar-light bg-white">
      <span class="navbar-brand col-md-3 col-sm-12">
        <a class="mx-auto" href="/login_sugar">
          <img class="img-fluid" src="../../images/logo_cb.png" alt="Casabaca Api" />
        </a>
      </span>
      <span>
        <strong>{{user.rol}} : </strong>{{user.name}}
      </span>
      <a href="logout_sugar">
        <Button label="Cerrar Sesion" icon="pi pi-users" class="p-button-raised p-button-danger p-button-text text-rigth" />
      </a>
    </nav>
  </div>
  <form class="p-3 rounded-lg bg-white">
    <div class="row">
    <div class="form-group col-md-3 pr-md-0">
      <label>Tipo de documento<strong style="color: red"> *</strong>:</label><br>
      <div class="form-check form-check-inline" v-for="typeD of typeDocuments" :key="typeD.code" >
        <RadioButton class="form-check-input" @change="changeType()"  :id="typeD.code" name="typeD" :value="typeD" v-model="selectedType" />
        <label class="form-check-label" :for="typeD.code">{{typeD.name}}</label>
      </div>
    </div>
    <div class="form-group p-fluid col-md-3" >
      <label>Número de documento<strong style="color: red"> *</strong>:</label>
      <InputText v-model="state.numero_identificacion" @blur="searchDocument();v$.numero_identificacion.$touch()" @input="changeDocument()" :class="['p-inputtext-sm',{'p-invalid':v$.numero_identificacion.$error}]"  maxlength="13" type="text"  placeholder="Número de documento"/>
      <small v-if="v$.numero_identificacion.$errors[0] "  class="p-error">{{ v$.numero_identificacion.$errors[0].$message }}</small>
    </div>
    <div class="form-group p-fluid col">
      <label>Nombres<strong style="color: red"> *</strong>:</label>
      <InputText v-model="state.names" :class="['p-inputtext-sm',{'p-invalid':v$.names.$error}]" type="text" placeholder="Ingrese nombres" />
      <small v-if="v$.names.$errors[0] " class="p-error">{{ v$.names.$errors[0].$message }}</small>
    </div>
    <div class="form-group p-fluid col-md-3" :hidden="tipoRuc != '01'">
      <label>Apellidos<strong style="color: red"> *</strong>:</label>
      <InputText v-model="state.surnames" :class="['p-inputtext-sm',{'p-invalid':v$.surnames.$error}]" type="text" placeholder="Ingrese apellidos" />
      <small v-if="v$.surnames.$errors[0] " class="p-error">{{ v$.surnames.$errors[0].$message }}</small>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="form-group p-fluid col">
      <label>Correo Electrónico<strong style="color: red"> *</strong>:</label>
      <InputText v-model="state.email" :class="['p-inputtext-sm',{'p-invalid':v$.email.$error}]" type="text" placeholder="Ingrese correo electrónico" />
      <small v-if="v$.email.$errors[0] " class="p-error">{{ v$.email.$errors[0].$message }}</small>
    </div>
    <div class="form-group p-fluid col-md-3">
      <label>Teléfono<strong style="color: red"> *</strong>:</label>
      <InputText v-model="state.phone_home" maxlength="9" :class="['p-inputtext-sm',{'p-invalid':v$.phone_home.$error}]" type="text" placeholder="Ingrese teléfono" />
      <small v-if="v$.phone_home.$errors[0] " class="p-error">{{ v$.phone_home.$errors[0].$message }}</small>
    </div>
    <div class="form-group p-fluid col-md-3" >
      <label>Celular<strong style="color: red"> *</strong>:</label>
      <InputText v-model="state.cellphone_number" maxlength="10" :class="['p-inputtext-sm',{'p-invalid':v$.cellphone_number.$error}]" type="text" placeholder="Ingrese celular" />
      <small v-if="v$.cellphone_number.$errors[0] " class="p-error">{{ v$.cellphone_number.$errors[0].$message }}</small>
    </div>
    <div class="form-group col-md-3" :hidden="tipoRuc != '01'">
      <label>Género<strong style="color: red"> *</strong>:</label><br>
        <div class="form-check form-check-inline" v-for="gender of genders" :key="gender.code" >
          <RadioButton class="form-check-input" :id="gender.code" name="gender" :value="gender" v-model="selectedGender" />
          <label class="form-check-label" :for="gender.code">{{gender.name}}</label>
        </div>
      </div>
    </div>
    <hr />
    <div class="row">
      <div class="form-group p-fluid col-md-3">
        <label>Agencia<strong style="color: red"> *</strong>:</label>
        <Dropdown @change="getBussiness()" v-model="state.agencia" :class="['p-inputtext-sm',{'p-invalid':v$.agencia.$error}]" :options="agencies" optionLabel="name" optionValue="code" placeholder="Escoja una agencia" :filter="validFilterCombo('agencies')" filterPlaceholder="Buscar" :disabled="validSizeCombo('agencies')" />
        <small v-if="v$.agencia.$errors[0] " class="p-error">{{ v$.agencia.$errors[0].$message }}</small>
      </div>
      <div class="form-group p-fluid col-md-3">
        <label>Linea de negocio<strong style="color: red"> *</strong>:</label>
        <Dropdown @change="getAdvisers()" v-model="state.cb_lineanegocio_id_c" :class="['p-inputtext-sm',{'p-invalid':v$.cb_lineanegocio_id_c.$error}]" :options="bussiness" optionLabel="name" optionValue="code" placeholder="Escoja una linea de negocio" :filter="validFilterCombo('typeDocuments')" filterPlaceholder="Buscar" :disabled="validSizeCombo('bussiness')"/>
        <small v-if="v$.cb_lineanegocio_id_c.$errors[0] " class="p-error">{{ v$.cb_lineanegocio_id_c.$errors[0].$message }}</small>
      </div>
      <div class="form-group p-fluid col-md-3">
        <label>Asesor<strong style="color: red"> *</strong>:</label>
        <Dropdown v-model="state.assigned_user_id" :class="['p-inputtext-sm',{'p-invalid':v$.assigned_user_id.$error}]" :options="advisers" optionLabel="name" optionValue="code" placeholder="Escoja un asesor" :filter="validFilterCombo('advisers')" filterPlaceholder="Buscar" :disabled="validSizeCombo('advisers')"/>
        <small v-if="v$.assigned_user_id.$errors[0] " class="p-error">{{ v$.assigned_user_id.$errors[0].$message }}</small>
      </div>
      <div class="form-group p-fluid col-md-3">
        <label>Campaña<strong style="color: red"> *</strong>:</label>
        <Dropdown v-model="state.campaign_id_c" :class="['p-inputtext-sm',{'p-invalid':v$.campaign_id_c.$error}]" :options="campaigns" optionLabel="name" optionValue="code" placeholder="Escoja una campaña" :filter="validFilterCombo('campaigns')" filterPlaceholder="Buscar" :disabled="validSizeCombo('campaigns')" />
        <small v-if="v$.campaign_id_c.$errors[0] " class="p-error">{{ v$.campaign_id_c.$errors[0].$message }}</small>
      </div>
    </div>
    <hr />
    <div class="row">
      <div class="form-group p-fluid col-md-12">
        <label>Comentario<strong style="color: red"> *</strong>:</label>
        <Textarea v-model="state.description" :class="['p-inputtext-sm',{'p-invalid':v$.description.$error}]"  :autoResize="true" rows="6" cols="6" />
        <small v-if="v$.description.$errors[0] " class="p-error">{{ v$.description.$errors[0].$message }}</small>
      </div>
    </div>
    <div class="row">
      <div class="col text-md-left text-center my-3">
        <Button type="button" label="Guardar" @click="handleSubmit()" icon="pi pi-save" class="p-button p-button-danger  text-rigth" :disabled="!documentValid"/>
      </div>
      <div class="col-md-3 text-right px-0 mx-3">
        <a class="mx-auto" href="/login_sugar">
          <img class="img-fluid" src="../../images/logo_1001.png" alt="1001 Api"  style="background: #250670 ;"/>
        </a>
      </div>
    </div>
  </form>
</template>

<script>
import {reactive, ref, onBeforeMount} from 'vue';
import { required, email, helpers, numeric, minLength, maxLength } from '@vuelidate/validators';
import useValidate from '@vuelidate/core';
import { useToast } from "primevue/usetoast";

const startCero = helpers.regex('startCero', /^0[1-9]\d*$/);
const startCeroNine = helpers.regex('startCeroNine', /^09\d*$/);

export default {
  name: "CampaingsMain",
  props: {
    agencies : Object,
    combos : Array,
    campaigns : Array,
    bussiness : Array,
    user: Object,
  },
  setup(props) {
    const toast = useToast();
    const agencies = ref(props.agencies);
    const campaigns = ref(props.campaigns);
    const bandSend = ref(false);
    let bussiness = ref(props.bussiness);
    let documentValid = ref(false);
    let tipoRuc = ref('01');
    let advisers = ref([]);
    let selectedType = ref();
    let urlSugar = ref();
    let selectedGender = ref();
    let sospechoso = reactive({
      band : 0,
      text : null
    });
    let save = ref(false);
    const typeDocuments = ref([
      { name: "Cédula", code: "C" },
      { name: "RUC", code: "R" },
      { name: "Pasaporte", code: "P" },
    ]);

    const genders = ref([
      { name: "Masculino", code: "M" },
      { name: "Femenino", code: "F" },
    ]);

    let state = reactive({
      tipo_identificacion: ref(),
      numero_identificacion: ref(''),
      names: ref(),
      surnames: ref(),
      email: ref(),
      cellphone_number: ref(),
      phone_home: ref(),
      cb_lineanegocio_id_c: ref(),
      assigned_user_id: ref(),
      agencia: ref(),
      campaign_id_c: ref(),
      genero: ref(),
      description: ref(),
    });

    const rules = {
      tipo_identificacion: { required: helpers.withMessage('El campo es requerido', required) },
      numero_identificacion: {
        required: helpers.withMessage('El campo es requerido', required),
        minLength: helpers.withMessage('El campo debe tener mínimo 10 caracteres',  minLength(10)),
        maxLength: helpers.withMessage('El campo debe tener máximo 13 caracteres',  maxLength(13))
      },
      names: { required: helpers.withMessage('El campo es requerido', required) },
      surnames: { required: helpers.withMessage('El campo es requerido',required) },
      email: {
        required: helpers.withMessage('El campo es requerido', required),
        email: helpers.withMessage('Correo Electrónico no valido', email) },
      cellphone_number: {
        required: helpers.withMessage('El campo es requerido', required),
        numeric: helpers.withMessage('El campo solo debe ser números', numeric),
        minLength: helpers.withMessage('El campo debe tener 10 dígitos',  minLength(10)),
        maxLength: helpers.withMessage('El campo debe tener 10 dígitos',  maxLength(10))
      },
      phone_home: {
        required: helpers.withMessage('El campo es requerido', required) ,
        numeric: helpers.withMessage('El campo solo debe ser números', numeric),
        minLength: helpers.withMessage('El campo debe tener mínimo 9 dígitos',  minLength(9)),
        maxLength: helpers.withMessage('El campo debe tener máximo 9 dígitos',  maxLength(9))
      },
      cb_lineanegocio_id_c: { required: helpers.withMessage('El campo es requerido', required) },
      assigned_user_id: { required: helpers.withMessage('El campo es requerido', required) },
      campaign_id_c: { required: helpers.withMessage('El campo es requerido', required) },
      agencia: { required: helpers.withMessage('El campo es requerido', required) },
      genero: { required: helpers.withMessage('El campo es requerido', required) },
      description: { required: helpers.withMessage('El campo es requerido', required) },
    };

    const v$ =  useValidate(rules, state);
    const validSizeCombo = (combo) => {
      if (eval(combo).value.length > 1) {
        return false;
      }
      return true;
    }

    const validFilterCombo = (combo) => {
      if (eval(combo).value.length > 5) {
        return true;
      }
      return false
    }

    const changeType = async () => {
      resetInfoSearch();
    }

    const changeDocument = async () => {
      resetInfoSearch();
    }

    const getBussiness = async () => {
      try {
        state.cb_lineanegocio_id_c = null;
        let res = await axios.get("/services/getBussiness", {
          params: {
            agency: state.agencia
          }
        });
        bussiness.value =  res.data;
      }catch (e) {
        console.log(e);
      }
    }

    const getAdvisers = async () => {
      if(!props.combos.includes('asesor')){
        return;
      }
      try {
        state.assigned_user_id = null;
        let  res = await axios.get('/services/getAdvisers',{
          params: {
            agency: state.agencia,
            bussiness: state.cb_lineanegocio_id_c,
          }
        });
        advisers.value =  res.data;
      }catch (e) {
        console.log(e);
      }
    }

    const handleSubmit = () => {
      bandSend.value = true;
      state.tipo_identificacion = selectedType.value.code;
      if(tipoRuc.value != '01'){
        state.surnames = 'especial';
      }
      state.genero = selectedGender.value.code;
      v$.value.$touch();
      if(!v$.value.$invalid){
        if(tipoRuc.value != '01'){
          state.surnames = null;
          state.genero = null;
        }
        sendData();
      }else{
        bandSend.value = false;
      }
    }

    const searchDocument = async () => {
      try {
        bandSend.value = true;
        documentValid.value = false;
        if(state.numero_identificacion.length < 10){
          bandSend.value = false;
          return;
        }
        let  res = await axios.get('/services/getDocument',{
          params: {
            type: selectedType.value.code,
            document: state.numero_identificacion,
          }
        });
        let data = res.data;
        documentValid.value = data.valid;
        if(!data.valid){
          resetInfoSearch();
          toast.add({severity:'warn', summary: data.error, life: 3000});
        }else{
          resetInfoSearch(data);
        }
        bandSend.value = false;
      }catch (e) {
        console.log(e);
        toast.add({severity:'error', summary: 'WebService inhabilitado', life: 3000});
        bandSend.value = false;
      }
    }

    const resetInfoSearch = async (data = null) => {
      state.names = (data !=null) ? data.firstName : null;
      state.surnames = (data !=null) ? data.lastName : null;
      state.email = (data !=null) ? data.email : null;
      state.cellphone_number = (data !=null) ? data.phoneMobile : null;
      state.phone_home = (data !=null) ? data.phoneHome : null;
      selectedGender.value = (data != null) ? (data.genero == 'M') ? genders.value[0] : genders.value[1] : genders.value[0];
      tipoRuc.value = (data !=null) ? data.tipoRuc : '01';
      sospechoso.band = (data !=null) ? data.sospechoso : 0;
      sospechoso.text = (data !=null) ? data.sospechosoText : null;
    }

      const sendData = async () => {
        try {
          let res = await axios.post("/campaigns", state);
          resetData();
          if(!props.combos.includes('asesor')){
            urlSugar.value = res.data.data;
            save.value = true;
          }else{
            toast.add({severity:'success', summary: 'Guardado Correctamente', life: 3000});
          }
        }catch (e) {
          console.log(e);
          toast.add({severity:'error', summary: 'WebService inhabilitado', life: 3000});
          bandSend.value = false;
        }
      }

    const resetData = () => {
      documentValid.value = false;
      selectedType.value = typeDocuments.value[0];
      selectedGender.value = genders.value[0];
      tipoRuc.value = '01';
      v$.value.$reset();
      state.tipo_identificacion = null;
      state.numero_identificacion = '';
      state.genero = null;
      resetInfoSearch();
      state.description = null;
      setTimeout(() => {
        bandSend.value = false;
      },500);
      validCombo();
    }

    onBeforeMount(() =>{
      resetData();
    });

    const validCombo = () => {
      state.campaign_id_c = (campaigns.value.length == 1) ? campaigns.value[0].code : null;
      state.agencia = (agencies.value.length == 1) ? agencies.value[0].code : null;
      state.cb_lineanegocio_id_c = (bussiness.value.length == 1) ? bussiness.value[0].code : null;
      if(!props.combos.includes('asesor')){
        advisers.value =  [props.user];
        state.assigned_user_id = advisers.value[0].code;
      }else{
        state.assigned_user_id = null;
      }
      if(props.combos.includes('agencia')){
        state.agencia = props.user.agencia;
        getBussiness();
        bussiness.value = [];
      }
      if(props.combos.includes('asesor')){
        advisers.value = [];
      }
    }

    return {getAdvisers, getBussiness, validFilterCombo, validSizeCombo,
            bussiness, typeDocuments, v$, campaigns, genders, agencies,
            advisers, handleSubmit, state, selectedType, searchDocument,
            selectedGender, changeType, changeDocument, bandSend, documentValid,
            tipoRuc, sospechoso, save, urlSugar
    };
  }
}

</script>

<style scoped>
a:link, a:visited, a:active {
  text-decoration:none;
}
.p-sidebar {
  height: 2rem !important;
}
</style>
