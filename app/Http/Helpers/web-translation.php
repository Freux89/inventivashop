  <form class="form-horizontal" action="{{ route('admin.languages.key_value_store') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $language->id }}">

      <table class="table table-row-dashed w-100 dt-responsive nowrap align-middle no-footer" id="tranlation-table"
          cellspacing="0" width="100%">
          <tbody>
              @foreach ($localizations as $key => $localization)
                  <tr class="px-0">
                      <td>{{ $key + 1 + ($localizations->currentPage() - 1) * $localizations->perPage() }}
                      </td>
                      <td class="key">{{ $localization->t_value }}</td>
                      <td class="pe-0">
                          <input type="text" class="form-control value w-100"
                              name="values[{{ $localization->t_key }}]"
                              @if (($traslate_lang = \App\Models\Localization::where('lang_key', $language->code)->where('t_key', $localization->t_key)->latest()->first()) != null) value="{{ $traslate_lang->t_value }}" @endif>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>

      <div class="form-group mt-3 row justify-content-between">
          <div class="col-12 col-md-8 order-2 order-md-0">
              {{ $localizations->appends(request()->input())->links() }}
          </div>
          <div class="col-12 col-md-4 mb-2 mb-md-0 text-end">
              <button type="button" class="btn btn-primary"
                  onclick="copyTranslation()">{{ localize('Copy Translations') }}</button>
              <button type="submit" class="btn btn-primary">{{ localize('Save') }}</button>
          </div>
      </div>
  </form>

  @section('scripts')
      <script type="text/javascript">
          //translate in one click
          function copyTranslation() {
              $('#tranlation-table > tbody  > tr').each(function(index, tr) {
                  $(tr).find('.value').val($(tr).find('.key').text());
              });
          }
      </script>
  @endsection
