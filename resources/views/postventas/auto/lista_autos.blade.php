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

<!-- Vertically Centered Default Modal -->
<div class="modal" id="modal-default-vcenter" tabindex="-1" role="dialog" aria-labelledby="modal-default-vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agenda </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-1">
                {!! Form::open(['url' => 'foo/bar']) !!}
                <div class="mb-4">
                    <label class="form-label" for="example-textarea-input">Asunto</label>
                    <input class="form-control" name="example-textarea-input" placeholder="Textarea content.." />
                </div>
                <div class="mb-4">
                    <label class="form-label" for="example-textarea-input">Comentario</label>
                    <textarea class="form-control" id="example-textarea-input" name="example-textarea-input" rows="4" placeholder="Textarea content.."></textarea>
                </div>
                <div class="row">
                    <div class="col-xl-7 mb-4">
                        <label class="form-label" for="example-flatpickr-default">Default format</label>
                        <input type="text" class="js-flatpickr form-control " id="example-flatpickr-datetime" name="example-flatpickr-datetime" data-enable-time="true" readonly="readonly">
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>
<!-- END Vertically Centered Default Modal -->

<!-- Extra Large Block Modal -->
<div class="modal" id="modal-post-oportunidades" tabindex="-1" role="dialog" aria-labelledby="modal-post-oportunidades" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Modal Title</h3>
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
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Done</button>
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
        function envia_post_data(id,token,data){
            //do stuff
            all_is_done=true;
            //$("#form_master"+id).submit();
            console.log(eval("nuevacita"+id));
            console.log(eval("recordatorio"+id));
            console.log(eval("desiste"+id));
            //alert('all done lanzar fomrulario.');
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
                    }
                },
                error: function(error) {
                    console.error('Error 2xjo');
                    console.error(error);
                    console.log(error);
                }
            });

        }
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

        submitFomr();

    </script>
@endsection
