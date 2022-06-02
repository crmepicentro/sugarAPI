<div id="autosAC" role="tablist" aria-multiselectable="true">
    @php($auto != null ? $autos = [$auto] :  $autos = $propietario->autos )
    @php($accion_opp = "")
    @foreach( $autos as $auto)
    <div class="block block-rounded mb-1">
        <div class="block-header block-header-default" role="tab" id="autosAC_h{{$loop->index}}">
            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#autosAC" href="#autosAC_q{{$loop->index}}" aria-expanded="true" aria-controls="autosAC_q{{$loop->index}}">PLACA: {{ $auto->placa }} | {{ $auto->modelo }} | {{ $auto->descVehiculo }} </a>
        </div>
        <div id="autosAC_q{{$loop->index}}" class="collapse show" role="tabpanel" aria-labelledby="autosAC_h{{$loop->index}}" style="">
            <div class="block-content">
                @include('postventas.oportunidades.show_op')
            </div>
        </div>
    </div>
    @php($accion_opp .= "var nuevacita$auto->id= [];var recordatorio$auto->id= [];var desiste$auto->id= [];")
    @endforeach
</div>


<!-- Extra Large Block Modal -->
<div class="modal" id="modal-post-oportunidades" tabindex="-1" role="dialog" aria-labelledby="modal-post-oportunidades" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Modal Gestión de Oportunidades</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div id="cuertpo_postOportunidades"></div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Extra Large Block Modal -->

@section('js_after')
    @parent
    <script>
        {!! $accion_opp !!}

        /**
         * Funcion para mostrar el modal de gestion de oportunidades
         * @param nombre_campo
         * @param lineaId
         * @param deshabilitamasterButon
         * @param nombre_variable
         * @param vector_eventos
         * @param id_auto
         */
        function checkLine(nombre_campo,lineaId,deshabilitamasterButon,nombre_variable,vector_eventos,id_auto){
            activaBotonMaster(id_auto);

            if(deshabilitamasterButon != null){
                var arrayDeCadenas_d = deshabilitamasterButon.split(';');
            }else{
                var arrayDeCadenas_d = [];
            }
            $( '#'+nombre_campo ).on( "click", function() {
                if($( '#'+nombre_campo ).is(':checked'))
                {
                    // checked
                    vector_eventos.push(nombre_variable);
                    $('.'+lineaId).removeAttr('checked');
                    $('.'+lineaId).attr('disabled', true);
                    $('.'+lineaId).prop( "checked", false );
                    $( '#'+nombre_campo ).prop( "checked", true );
                    $( '#'+nombre_campo ).attr('disabled', false);
                    $( '#'+nombre_campo ).removeAttr('disabled');
                    for (var i=0; i < arrayDeCadenas_d.length; i++) {
                        $(arrayDeCadenas_d[i]).attr('disabled', true);
                    }
                    activaBotonMaster(id_auto);
                }else
                {
                    // unchecked
                    vector_eventos.splice(vector_eventos.indexOf(nombre_variable), 1);
                    $('.'+lineaId).attr('disabled', false);
                    for (var i=0; i < arrayDeCadenas_d.length; i++) {
                        $(arrayDeCadenas_d[i]).attr('disabled', false);
                        $(arrayDeCadenas_d[i]).removeAttr('disabled');
                    }
                    activaBotonMaster(id_auto);
                }
            });
        }
        function activaBotonMaster(id){
            if(!eval("nuevacita"+id).length > 0){
                $(".ejecutaCita"+id).attr('disabled', true);
            }else{
                $(".ejecutaCita"+id).attr('disabled', false);
                $(".ejecutaCita"+id).removeAttr('disabled');
            }
            if(!eval("recordatorio"+id).length>0){
                $(".super_agenda_"+id).attr('disabled', true);
            }else{
                $(".super_agenda_"+id).attr('disabled', false);
                $(".super_agenda_"+id).removeAttr('disabled');
            }
            if(!eval("desiste"+id).length>0){
                $(".super_perdida_"+id).attr('disabled', true);
            }else{
                $(".super_perdida_"+id).attr('disabled', false);
                $(".super_perdida_"+id).removeAttr('disabled');
            }
            var elem = document.querySelector(".total_accion_"+id);
            var typeId = elem.getAttribute('data-porte');
            if(eval("nuevacita"+id).length + eval("recordatorio"+id).length + eval("desiste"+id).length == typeId ){
                $(".total_accion_"+id).attr('disabled', false);
                $(".total_accion_"+id).attr('disabled', false);
            }else{
                $(".total_accion_"+id).attr('disabled', true);
            }
        }
        //
        /**
         * Funcion para mostrar el modal de gestion de oportunidades
         * @param id auto
         * @param token token de formulario
         * @param data
         */
        function envia_post_data(id,token,data){
            //do stuff
            all_is_done=true;
            var url_post = '{{ route('postventa.gestion') }}';
            $.ajax({
                url: url_post,
                type:"POST",
                data: {auto: id, data:data,_token: token,nuevacitas:eval("nuevacita"+id),recordatorios:eval("recordatorio"+id),desistes:eval("desiste"+id)},
                success:function(response){
                    //console.log(response);
                    if(response) {
                        $("#cuertpo_postOportunidades").html(response);
                        $("#modal-post-oportunidades").modal('show');
                        Dashmix.helpersOnLoad(['js-flatpickr','jq-validation','jq-datepicker']);
                    }
                },
                error: function(error) {
                    alert('Error al enviar los datos.: '+JSON.stringify(error));
                    console.error('Error Dfg90');
                    if(error.status==419){
                        alert('Su sesión ha expirado, porfavor vuelva a iniciar sesión.');
                    }
                    console.error(error);
                    console.log(error);
                }
            });

        }

        /**
         * Funcion para enviar un submit al formulario donde se colocan los detalles de gestion de oportunidades
         * @param id
         */
        function submitFomr(id){
            var all_is_done=false;
            $("#form_master"+id).submit(function(e){
                data = $("#form_master"+id).serializeArray();
                if(all_is_done==false){
                    e.preventDefault();
                    var fd = new FormData(this);
                    envia_post_data(id,fd.get('_token'),data);
                }
            });
        }
        /**
         * Funcion para enviar un submit a guardar las oportunidades si es una cita manda al s3s para que entregue el numero de cita
         * @param id
         */
        function submitFormFinGestion(id){
            var all_is_done=false;
            $("#form_fin_gestion"+id).submit(function(e){
                data = $("#form_fin_gestion"+id).serializeArray();
                console.log(data)
                if(all_is_done==false){
                    e.preventDefault();
                    envia_post_data_final(id,data);
                }
            });
        }
        function quitavalidacion(){
            $(".v4lp4r4z0").remove();
            $('input').removeClass('is-invalid');
            $('textarea').removeClass('is-invalid');
            $('select').removeClass('is-invalid');
        }
        function envia_post_data_final(id,data){
            quitavalidacion()
            //do stuff
            all_is_done=true;

            var url_post = $("#form_fin_gestion"+id).attr('action');
            $.ajax({
                url: url_post,
                type:"POST",
                data: data,
                success:function(response){
                    //console.log(response);
                    if(response) {
                        $("#cuertpo_postOportunidades").html(response);
                        $("#modal-post-oportunidades").modal('show');
                        Dashmix.helpersOnLoad(['js-flatpickr','jq-validation','jq-datepicker']);
                    }
                },
                error: function(error) {
                    console.error('Error 2xjo');
                    //alert('Error al enviar los datos.: '+JSON.stringify(error));
                    if(error.status==419){
                        alert('Su sesión ha expirado, porfavor vuelva a iniciar sesión.');
                    }
                    if(error.status==422){
                        var errors = error.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $("#"+key).attr("title", value).addClass("is-invalid").after( "<p class='v4lp4r4z0 invalid-feedback animated fadeIn'>"+value+"</p>" );

                        });
                    }

                }
            });
        }

        function bt_envioparcial(id,class_name){
            console.log(id);
            var campos_cita = document.getElementsByClassName(class_name);
            const array_citas = [];
            for (var i = 0; i < campos_cita.length; i++) {
                if(campos_cita[i].checked) {
                    //alert (campos_cita[i].value);
                    console.log(campos_cita[i].name);
                    var objeto_cita = { 'name' : campos_cita[i].name , 'value' : campos_cita[i].value };
                    array_citas.push(objeto_cita);
                }
            };
            //
            data = array_citas;
            switch (class_name) {
                case 'citKm':
                    eval("recordatorio"+id+ " = []");
                    eval("desiste"+id+ " = []");
                    break;
                case 'recKm':
                    eval("nuevacita"+id+ " = []");
                    eval("desiste"+id+ " = []");
                    break;
                case 'perKm':
                    eval("nuevacita"+id+ " = []");
                    eval("recordatorio"+id+ " = []");
                    break;
            }
            envia_post_data(id,'{{ csrf_token() }}',data);
        }
        submitFomr();

    </script>
@endsection
