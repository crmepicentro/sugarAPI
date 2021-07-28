<template>
    <TabMenu style="font-size: 11px" :model="items" :rendered="true" :activeIndex="0"/>
    <router-view />
</template>
<script>
import { ref } from 'vue';
import moment from 'moment-timezone';

export default {
    name: 'App',
    props: {numero_identificacion: String, ticket_id: String, modulo: String},
    setup(props) {
       const items = ref([
            {label: 'Contacto', icon: 'pi pi-fw pi-user', to: '/client/' + props.numero_identificacion},
            {label: 'Historial Tickets', icon: 'pi pi-fw pi-ticket', to: '/tickets/' + props.numero_identificacion},
            {label: 'Negociaciones', icon: 'pi pi-fw pi-money-bill', to: '/talks/' + props.numero_identificacion}
        ]);

       if(props.ticket_id){
         items.value.push({label: 'Car Match', icon: 'pi pi-fw pi-money-bill', to: '/carmatch/' + props.ticket_id});
       }

        return {
            items,
            props,
            moment
        };
    },
}
</script>
<style scoped>
body .p-menu .p-menu-list > .p-submenu-header {
    display: none;
}
body .p-menu .p-menuitem.p-menuitem-active > .p-menuitem-link {
    background-color: #eaeaea;
}

</style>
<style scoped lang="scss">
::v-deep(.tabmenudemo-content) {
    padding: 2rem 1rem;
}
</style>
