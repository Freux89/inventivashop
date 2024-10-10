 <div class="modal fade addAddressModal" id="addAddressModal">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">{{ localize('Add New Address') }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('address.store') }}" method="POST">
                     @csrf

                     <div class="col my-5 billing-field">
                         <label class="d-block mb-3">{{ localize('Tipo di fatturazione') }}</label>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="billing_type" id="billingTypeCompany" value="company" checked onclick="toggleBillingFields('company')">
                             <label class="form-check-label" for="billingTypeCompany">{{ localize('Azienda') }}</label>
                         </div>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="billing_type" id="billingTypePrivate" value="private" onclick="toggleBillingFields('private')">
                             <label class="form-check-label" for="billingTypePrivate">{{ localize('Privato') }}</label>
                         </div>
                     </div>

                     <div class="row g-4">
                         <!-- Nome indirizzo - specifico per spedizione -->
                         <div class="col-md-6 shipping-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Nome indirizzo') }}</label>
                                 <input type="text" name="address_name" placeholder="{{ localize('Nome indirizzo') }}" required>
                             </div>
                         </div>

                         <!-- Nazione - comune -->
                         <div class="col-md-6 common-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Nazione') }}</label>
                                 <select name="country_id" class="select2Address" required>
                                     <option value="">{{ localize('Select Country') }}</option>
                                     @foreach ($countries as $country)
                                     <option value="{{ $country->id }}">{{ $country->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <!-- Nome - comune -->
                         <div class="col-md-6 common-field private-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Nome') }}</label>
                                 <input type="text" name="first_name" placeholder="{{ localize('Nome') }}" required>
                             </div>
                         </div>

                         <!-- Cognome - comune -->
                         <div class="col-md-6 common-field private-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Cognome') }}</label>
                                 <input type="text" name="last_name" placeholder="{{ localize('Cognome') }}" required>
                             </div>
                         </div>

                         <!-- Codice fiscale - specifico per fatturazione -->
                         <div class="col-md-6 billing-field private-field" style="display: none;">
                             <div class="label-input-field">
                                 <label>{{ localize('CF') }}</label>
                                 <input type="text" name="fiscal_code" placeholder="{{ localize('CF') }}" required>
                             </div>
                         </div>

                         <!-- Partita IVA - specifico per fatturazione -->
                         <div class="col-md-6 billing-field company-field" style="display: none;">
                             <div class="label-input-field">
                                 <label>{{ localize('Partita IVA') }}</label>
                                 <input type="text" name="vat_id" placeholder="{{ localize('Partita IVA') }}" required>
                             </div>
                         </div>

                         <!-- Nome azienda - specifico per fatturazione -->
                         <div class="col-md-6 billing-field company-field" style="display: none;">
                             <div class="label-input-field">
                                 <label>{{ localize('Nome azienda') }}</label>
                                 <input type="text" name="company_name" placeholder="{{ localize('Nome azienda') }}" required>
                             </div>
                         </div>

                         <!-- Codice SDI - specifico per fatturazione -->
                         <div class="col-md-6 billing-field company-field" style="display: none;">
                             <div class="label-input-field">
                                 <label>{{ localize('Codice SDI') }}</label>
                                 <input type="text" name="sdi_code" placeholder="{{ localize('Codice SDI') }}">
                             </div>
                         </div>

                         <!-- PEC - specifico per fatturazione -->
                         <div class="col-md-6 billing-field company-field" style="display: none;">
                             <div class="label-input-field">
                                 <label>{{ localize('PEC') }}</label>
                                 <input type="email" name="pec" placeholder="{{ localize('PEC') }}">
                             </div>
                         </div>
                         <!-- Indirizzo - comune -->
                         <div class="col-md-6 common-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Indirizzo') }}</label>
                                 <input type="text" name="address" placeholder="{{ localize('Indirizzo') }}" required>
                             </div>
                         </div>
                         <!-- CAP - comune -->
                         <div class="col-md-6 common-field">
                             <div class="label-input-field">
                                 <label>{{ localize('CAP') }}</label>
                                 <input type="text" name="postal_code" placeholder="{{ localize('CAP') }}" required>
                             </div>
                         </div>

                         <!-- Città - comune -->
                         <div class="col-md-6 common-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Città') }}</label>
                                 <input type="text" name="city" placeholder="{{ localize('Città') }}" required>
                             </div>
                         </div>

                         <!-- Provincia - specifico per spedizione -->
                         <div class="col-md-6 common-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Provincia') }}</label>
                                 <select name="state_id" required>
                                     <!-- Opzioni provincia -->
                                 </select>
                             </div>
                         </div>

                         <!-- Telefono - comune -->
                         <div class="col-md-6 common-field">
                             <div class="label-input-field">
                                 <label>{{ localize('Telefono') }}</label>
                                 <input type="text" name="phone" placeholder="{{ localize('Telefono') }}">
                             </div>
                         </div>
                         <div class="col-12">
                             <button type="submit" class="btn btn-primary">{{ localize('Salva') }}</button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>





 <div class="modal fade editAddressModal" id="editAddressModal">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-body">
                 <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                 <div class="gstore-product-quick-view bg-white rounded-3 py-6 px-4">
                     <h2 class="modal-title fs-5 mb-3">{{ localize('Update Address') }}</h2>

                     <div class="spinner pt-6 pb-8 d-none">
                         <div class="row align-items-center g-4 mt-3">
                             <div class="d-flex justify-content-center">
                                 <div class="spinner-border" role="status">
                                     <span class="visually-hidden">Loading...</span>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div class="edit-address d-none">

                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <div class="modal fade deleteAddressModal" id="deleteAddressModal">
     <div class="modal-dialog address-delete-modal modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-body">
                 <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                 <div class="bg-white rounded-3 py-6 px-4">
                     <h2 class="modal-title fs-5 mb-3">{{ localize('Delete Address') }}</h2>
                     <div class="pt-6 pb-8 text-center">
                         <h6>{{ localize('Want to delete this address?') }}</h6>
                     </div>
                     <div class="text-center">
                         <a href="" class="btn btn-secondary delete-address-link">{{ localize('Delete') }}</a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>


 @section('scripts')
 <script>
     "use strict";

     var parent = '.addAddressModal';

     // runs when the document is ready --> for media files
     $(document).ready(function() {
         if ($("input[name='shipping_address_id']").is(':checked')) {
             let country_id = $("input[name='shipping_address_id']:checked").data('country_id');
             getLogistics(country_id);
         }
     });


     function addNewAddress(addressType) {

         toggleAddressFields(addressType);
         // Mostra il modal
         $('#addAddressModal').modal('show');
     }

     

     //  edit address
     function editAddress(addressId) {
         $('#editAddressModal').modal('show');
         $('.spinner').removeClass('d-none');
         $('.edit-address').addClass('d-none');

         parent = '.editAddressModal';
         getAddress(addressId);
     }

     //  delete address
     function deleteAddress(thisAnchorTag) {
         $('#deleteAddressModal').modal('show');
         $('.delete-address-link').prop('href', $(thisAnchorTag).data('url'));
     }

     //  get states on country change
     $(document).on('change', '[name=country_id]', function() {
         var country_id = $(this).val();
         getStates(country_id);
     });

     //  get states
     function getStates(country_id) {
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
             },
             url: "{{ route('address.getStates') }}",
             type: 'POST',
             data: {
                 country_id: country_id
             },
             success: function(response) {
                 $('[name="state_id"]').html("");
                 $('[name="state_id"]').html(JSON.parse(response));
                 addressModalSelect2(parent);
             }
         });
     }

     //  get cities on state change


     //  get cities


     //  get edit address
     function getAddress(addressId) {
         $.ajax({
             headers: {
                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
             },
             url: "{{ route('address.edit') }}",
             type: 'POST',
             data: {
                 addressId: addressId
             },
             success: function(response) {
                 $('.spinner').addClass('d-none');
                 $('.edit-address').html(response.content);
                 $('.edit-address').removeClass('d-none');
                 addressModalSelect2(parent);
                 toggleAddressFields(response.addressType);
                 if(response.documentType == 1) {
                     $('#billingTypeCompany').prop('checked', true);
                     toggleBillingFields('company');
                 } else if(response.documentType == 2) {
                     $('#billingTypePrivate').prop('checked', true);
                     toggleBillingFields('private');
                 }

             }
         });
     }



     function toggleAddressFields(addressType) {
         // Nascondi o mostra i campi specifici e aggiorna il required
         var billingFields = document.querySelectorAll('.billing-field');
         var shippingFields = document.querySelectorAll('.shipping-field');
         var commonFields = document.querySelectorAll('.common-field');


            commonFields.forEach(function(field) {
                field.style.display = 'block';
                // Aggiorna l'attributo required per i campi comuni
                field.querySelectorAll('input, select, textarea').forEach(function(input) {
                    input.required = true;
                });
            });

         billingFields.forEach(function(field) {
             field.style.display = addressType === 'billing' ? 'block' : 'none';
             // Aggiorna l'attributo required per i campi di fatturazione
             field.querySelectorAll('input, select, textarea').forEach(function(input) {
                 input.required = addressType === 'billing';
             });

             if (addressType === 'billing') {
                 // set address type company
                 $('#billingTypeCompany').prop('checked', true);
                 toggleBillingFields('company');
             }
         });

         shippingFields.forEach(function(field) {
             field.style.display = addressType === 'shipping' ? 'block' : 'none';
             // Aggiorna l'attributo required per i campi di spedizione
             field.querySelectorAll('input, select, textarea').forEach(function(input) {
                 input.required = addressType === 'shipping';
             });
         });

         // Aggiorna il titolo del modal in base al tipo di indirizzo
         var modalTitle = addressType === 'billing' ? '{{ localize("Aggiungi indirizzo di fatturazione") }}' : '{{ localize("Aggiungi indirizzo di spedizione") }}';
         document.querySelector('#addAddressModal .modal-title').textContent = modalTitle;
     }

     function toggleBillingFields(type) {
         var companyFields = document.querySelectorAll('.company-field');
         var privateFields = document.querySelectorAll('.private-field');

         if (type === 'company') {
             companyFields.forEach(field => {
                 field.style.display = 'block';
                 field.querySelectorAll('input, select, textarea').forEach(input => input.required = true);
             });
             privateFields.forEach(field => {
                 field.style.display = 'none';
                 field.querySelectorAll('input, select, textarea').forEach(input => input.required = false);
             });
         } else {
             companyFields.forEach(field => {
                 field.style.display = 'none';
                 field.querySelectorAll('input, select, textarea').forEach(input => input.required = false);
             });
             privateFields.forEach(field => {
                 field.style.display = 'block';
                 field.querySelectorAll('input, select, textarea').forEach(input => input.required = true);
             });
         }
     }



    // Nuova funzione per gestire l'apertura e chiusura dell'accordion con il form di modifica indirizzo
function openAccordionForEditAddress(addressId) {
    const accordion = document.querySelector(`#collapse-${addressId}`);
    const accordionBody = accordion.querySelector('.accordion-body');

    // Controlla se l'accordion è aperto
    const isExpanded = accordion.classList.contains('show');

    // Se l'accordion è aperto, chiudilo e ritorna
    if (isExpanded) {
        const accordionInstance = bootstrap.Collapse.getInstance(accordion);
        accordionInstance.hide();
        return;
    }

    // Mostra uno spinner o un indicatore di caricamento mentre attendiamo la risposta
    accordionBody.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';

    // Effettua la chiamata AJAX per ottenere il form di modifica indirizzo
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        url: "{{ route('address.edit') }}",
        type: 'POST',
        data: {
            addressId: addressId
        },
        success: function(response) {
            // Quando riceviamo il form, sostituiamo lo spinner con il form
            accordionBody.innerHTML = response.content;

            // Dopo che il form è stato caricato, apri l'accordion
            const accordionInstance = new bootstrap.Collapse(accordion, {
                toggle: true
            });

            accordionInstance.show();

            // Esegui altre funzioni, come select2 o toggle degli indirizzi
            addressModalSelect2(`#collapse-${addressId}`);
            toggleAddressFields(response.addressType);
            if (response.documentType == 1) {
                $('#billingTypeCompany').prop('checked', true);
                toggleBillingFields('company');
            } else if (response.documentType == 2) {
                $('#billingTypePrivate').prop('checked', true);
                toggleBillingFields('private');
            }
        },
        error: function() {
            // Gestione degli errori in caso di problemi con la chiamata AJAX
            accordionBody.innerHTML = '<div class="alert alert-danger">Error loading address form. Please try again.</div>';
        }
    });
}
// Funzione per inviare i campi del div come se fossero inviati tramite un form
function submitDivAsForm(addressId) {
    // Trova il div che contiene i campi
    const addressDiv = document.querySelector(`#editAddressForm-${addressId}`);

    // Crea un form temporaneo
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('address.update') }}"; // L'endpoint verso cui inviare i dati

    // Aggiunge il token CSRF
    const csrfToken = document.querySelector('input[name="_token"]').value;
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    // Raccoglie tutti i campi presenti nel div e li aggiunge al form temporaneo
    const inputs = addressDiv.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = input.name;
        hiddenInput.value = input.value;
        form.appendChild(hiddenInput);
    });

    // Aggiunge il form temporaneo al body e lo invia
    document.body.appendChild(form);
    form.submit();
}
// Funzione per chiudere l'accordion
function closeAccordion(addressId) {
    const accordion = document.querySelector(`#collapse-${addressId}`);
    const accordionInstance = bootstrap.Collapse.getInstance(accordion);
    accordionInstance.hide(); // Chiude l'accordion
}

// Aggiunge o rimuove la classe "active" quando un accordion si apre o chiude
document.querySelectorAll('.accordion-collapse').forEach(accordion => {
    accordion.addEventListener('show.bs.collapse', function () {
        this.closest('.accordion-item').classList.add('active');
    });
    
    accordion.addEventListener('hide.bs.collapse', function () {
        this.closest('.accordion-item').classList.remove('active');
    });
});
 </script>
 @endsection