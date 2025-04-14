<form action="{{ route('import') }}" id="form-import" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <input type="file" name="file" class="form-control-file" required />
        </div>
        @csrf

        {{-- <input type="text" name="tab" required /> --}}
        <div class="col-md-12 mt-2 mb-2">
            <select multiple required name="tab[]" id="tab" class="select2 form-control">
                <option value="lcf_entradas">Contas a Pagar</option>
                <option value="lcf_saidas">Contas a Receber</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Importar</button>
        </div>
    </div>
</form>
