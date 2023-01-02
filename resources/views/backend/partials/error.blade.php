@if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li class="error form-control-feedback">{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif