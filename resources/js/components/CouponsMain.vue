<template>
    <div class="row no-gutters mb-2">
        <nav class="navbar navbar-light bg-white">
          <span class="navbar-brand col-md-3 col-sm-12">
           <img class="img-fluid" src="../../images/logo_cb.png" alt="Casabaca Api"/>
          </span>
            <span class="navbar-brand col-md-3 col-sm-12 d-none d-md-block d-xl-block">
           <img class="img-fluid" src="../../images/logo_tsn.png" alt="TSN"/>
          </span>
        </nav>
    </div>
    <div class="p-3 rounded-lg bg-white " style="height: 73vh;">
        <div class="row ">
            <h3 class="col-12 text-center pb-md-4 p-text-bold text-danger">Cupones TSN</h3>
            <div class="col-md-4 offset-md-4 form-group p-fluid ">
                <label>Agencia de canje<strong style="color: red"> *</strong>:</label>
                <Dropdown  class="p-inputtext-sm" v-model="data.agencie" style="font-size: 0.875rem !important;"  :options="agencies" optionLabel="name" optionValue="code" placeholder="Escoja una agencia"  :filter="true" filterPlaceholder="Buscar"  />
            </div>
            <div class="col-md-4 offset-md-4 form-group p-fluid ">
                <label>Código Cupón<strong style="color: red"> *</strong>:</label>
                <div class="p-inputgroup">
                    <InputMask class="p-inputtext-lg text-center p-1" v-model="data.codeCoupon" mask="*** - *** - ***"
                               style="font-size: 150% !important;text-transform: uppercase;"/>
                    <Button icon="pi pi-search" class="p-button-danger"/>
                </div>
            </div>
            <div class="col-md-6 offset-md-3 text-center form-group p-fluid ">
                <label>Nombre:</label>
                <h3 style="text-transform: uppercase;">
                    {{data.name}}
                </h3>
            </div>
            <div class="col-12 text-center">
                <Button  label="Canjear" icon="pi pi-shopping-cart" class="p-button-raised p-button-rounded p-button-success" />
            </div>
        </div>
    </div>
    <div class="row no-gutters mt-2 d-md-none d-block ">
        <nav class="navbar navbar-light bg-white">
          <span class="navbar-brand text-center col-md-3 col-sm-12 ">
           <img class="img-fluid" src="../../images/logo_tsn.png" alt="TSN" style="width: 61%;"/>
          </span>
        </nav>
    </div>
</template>

<script>

import {reactive, ref} from "vue";

export default {
    name: "CouponsMain",
    props: {
        agencies : Object,
    },
    setup(props) {
        const agencies = ref(props.agencies);
        let data = reactive({
            agencie: ref(),
            name: ref('Cristian Geovanny Cazares Baldeon'),
            codeCoupon: ref(),
        });
        return {agencies,data};
    }
}

</script>

<style scoped>
.p-button.p-button-icon-only {
    min-width: 3.5rem !important;
}
</style>
