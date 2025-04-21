@php
    $tam_col1 = isset($config['tam_col1'])?$config['tam_col1'] : 'col-md-12';
    $tam_col2 = isset($config['tam_col2'])?$config['tam_col2'] : 'col-md-4';
    $ac = isset($form['config']['ac'])?$form['config']['ac'] : 'cad';
@endphp
<div class="row">
    <div class="{{$tam_col1}}">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ $title_form }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                {{App\Qlib\Qlib::formulario([
                    'campos'=>@$form['campos'],
                    'config'=>@$form['config'],
                    'value'=>@$form['value'],
                ])}}
            </div>
        </div>
    </div>
</div>
