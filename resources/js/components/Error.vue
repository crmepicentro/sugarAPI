
<template>
  <div class="p-card text-center m-auto p-3">
    <div class="p-card-title">
      <i class="pi pi-info-circle"></i>
    </div>
    <div class="p-card-title">
      {{msg.title}}
    </div>
    <div class="p-card-content  p-text-info">
      {{msg.texto}}
    </div>
    <div class="p-card-footer">
      <a href="logout_sugar">
        <Button label="Cerrar Sesion" icon="pi pi-users" class="p-button-raised p-button-danger p-button-text text-rigth" />
      </a>
    </div>
  </div>
</template>

<script>
import {ref} from "vue";

export default {
  name: "Error",
  props: {
    msg : Array,
  },
  setup(props) {
    const msg = ref(props.msg);
    return {msg};
  }
}
</script>

<style scoped>
.pi{
  font-size: 100PX;
  color: var(--warning);
}
.p-card-content{
  padding-left: 0rem !important;
}
.p-card{
  width: 50%;
}
a:link, a:visited, a:active {
  text-decoration:none;
}
</style>
