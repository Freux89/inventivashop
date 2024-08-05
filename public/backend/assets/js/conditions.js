$('#conditionFields').on('click', '.collapse-toggle', function (event) {
  const target = event.target;
  if (target.closest('.delete-condition, .duplicate-condition')) {
      return; // Non fare nulla se il click avviene su uno degli elementi specifici
  }
  // Altrimenti, attiva/disattiva il collapse
  const button = $(this);
  const collapseId = button.data('bs-target');
  const collapseElement = $(collapseId);
  collapseElement.collapse('toggle');
});

// Aggiungi stopPropagation ai pulsanti secondari
$('#conditionFields').on('click', '.delete-condition, .duplicate-condition', function (event) {
  event.stopPropagation();
});

function updateSelectedVariantValues(conditionIndex, selectedVariantValueId) {
  // Verifica se la variante è già stata selezionata in un'altra condizione
  var alreadySelected = Object.entries(selectedVariantValues).some(
    ([key, value]) => value === selectedVariantValueId && key !== conditionIndex
  );

  if (alreadySelected) {
    // La variante è già stata selezionata in un'altra condizione
    alert(
      "Questo valore di variante è già stato utilizzato in un'altra condizione. Seleziona un altro valore."
    );
    return false; // Ritorna false per indicare che l'aggiornamento non è avvenuto
  } else {
    // Aggiunge o aggiorna la variante selezionata per l'indice della condizione corrente
    selectedVariantValues[conditionIndex] = selectedVariantValueId;
    return true; // Ritorna true per indicare che l'aggiornamento è avvenuto con successo
  }
}

function updateActionSelectedVariants(
  conditionIndex,
  actionIndex,
  selectedVariantId
) {
  // Verifica se la variante è già stata selezionata in un'altra azione nella stessa condizione
  let conditionActions = selectedActionVariants[conditionIndex] || {};
  var alreadySelected = Object.entries(conditionActions).some(
    ([key, value]) =>
      value === selectedVariantId && key !== actionIndex.toString()
  );

  if (alreadySelected) {
    // La variante è già stata selezionata in un'altra azione nella stessa condizione
    alert(
      "Questa variante è già stata selezionata all'interno della stessa condizione. Seleziona un'altra variante."
    );
    return false; // Ritorna false per indicare che l'aggiornamento non è avvenuto
  } else {
    // Aggiorna o aggiunge la variante selezionata per l'indice dell'azione corrente nella condizione specificata
    if (!selectedActionVariants[conditionIndex]) {
      selectedActionVariants[conditionIndex] = {};
    }
    selectedActionVariants[conditionIndex][actionIndex] = selectedVariantId;
    return true; // Ritorna true per indicare che l'aggiornamento è avvenuto con successo
  }
}

function removeCondition(conditionIndex) {
  
  delete selectedVariantValues[conditionIndex];
  delete selectedActionVariants[conditionIndex];
  
}

function removeAction(conditionIndex, actionIndex) {
  if (selectedActionVariants[conditionIndex]) {
      delete selectedActionVariants[conditionIndex][actionIndex];
  }
}

function generateUniqueConditionIndex() {
  let conditionIndex = $(".condition-div").length;
  while ($(`.condition-div[data-condition-index="${conditionIndex}"]`).length > 0) {
      conditionIndex++;
  }
  return conditionIndex;
}

function generateUniqueActionIndex(conditionActionDiv) {
  let actionIndex = conditionActionDiv.find(".shutdown-action-div").length;
  while (conditionActionDiv.find(`.shutdown-action-div[data-action-index="${actionIndex}"]`).length > 0) {
      actionIndex++;
  }
  return actionIndex;
}



$(document).ready(function () {
  var conditionIndex = 0;

  var currentValue = null;

  $('input[type="radio"][name="products"]').on("click", function () {
    var newValue = $(this).val();

    // Mostra l'avviso solo se già esiste una selezione e ci sono condizioni create
    if (
      currentValue &&
      $(".condition-div").length > 0 &&
      newValue !== currentValue
    ) {
      var confirmChange = confirm(
        "Sei sicuro di cambiare prodotto? Se cambi prodotto verranno cancellate le condizioni create. Clicca su ok per procedere."
      );
      if (!confirmChange) {
        // Se l'utente annulla, ripristina la selezione precedente
        $('input[type="radio"][name="products"]').prop("checked", false);
        $(
          'input[type="radio"][name="products"][value="' + currentValue + '"]'
        ).prop("checked", true);
        return;
      }
      // Se l'utente conferma, pulisci le condizioni create
      $("#conditionFields").empty().hide();
      selectedVariantValues = [];
      selectedActionVariants = {};
    }

    // Aggiorna il valore corrente dopo la gestione della conferma
    currentValue = newValue;
  });

  $("#addConditionBtn").click(function () {
    var productId = $('input[type="radio"][name="products"]:checked').val();
    if (!productId) {
      alert("Seleziona un prodotto prima di aggiungere una condizione.");
      return;
    }
    $.ajax({
      url: variantsUrl,
      type: "GET",
      data: {
        productId: productId,
        conditionIndex: generateUniqueConditionIndex(),
      },
      success: function (response) {
        $("#conditionFields .collapse").collapse("hide");
        $("#conditionFields").append(response.html).show();
        $("#conditionFields .condition-div:last .collapse").collapse("show");
      },
      error: function (error) {
        console.log(error);
        alert("Si è verificato un errore durante il recupero delle varianti.");
      },
    });
  });

  $("#conditionFields").on("change", ".variant-select", function () {
    var selectedVariantId = $(this).val();

    var productId = $('input[type="radio"][name="products"]:checked').val();
    var currentConditionDiv = $(this).closest(".condition-div");
    if (!selectedVariantId) {
      currentConditionDiv.find(".variant-value-select, .value-label").remove();
      return;
    }
    currentConditionDiv.find(".condition-action").empty();
    var parentSelect = $(this).parent();
    var conditionIndex = currentConditionDiv.data("condition-index");

    $.ajax({
      url: variantValuesUrl,
      type: "GET",
      data: {
        productId: productId,
        variantId: selectedVariantId,
        conditionIndex: conditionIndex,
      },
      success: function (response) {
        var conditionDiv = parentSelect.closest(".condition-div");
        conditionDiv.find(".variant-value-select, .value-label").remove();
        conditionDiv.find(".btn-add-shutdown").hide();
        parentSelect.after(response.html);
      },
      error: function (error) {
        console.log(error);
        alert(
          "Si è verificato un errore durante il recupero dei valori delle varianti."
        );
      },
    });
  });

  $("#conditionFields").on("change", ".variant-value-select", function () {
    var currentConditionDefinition = $(this).closest(".condition-div");
    var addShutdownBtn = currentConditionDefinition.find(".btn-add-shutdown");
    if ($(this).val()) {
      addShutdownBtn.show();

      var conditionIndex = currentConditionDefinition.data("condition-index");
      var selectedVariantValueId = $(this).val();
      var updateSuccess = updateSelectedVariantValues(
        conditionIndex,
        selectedVariantValueId
      );
      if (!updateSuccess) {
        // Se la variante è già stata selezionata in un'altra condizione, resetta la select
        $(this).val("").trigger("change");
        return;
      }
    } else {
      addShutdownBtn.hide();
    }
  });

  $("#conditionFields").on("click", ".btn-add-shutdown", function () {
    var currentConditionDiv = $(this).closest(".condition-div");
    var conditionActionDiv = currentConditionDiv.find(".condition-action");
    var conditionIndex = currentConditionDiv.data("condition-index");
    var actionIndex = generateUniqueActionIndex(conditionActionDiv);
    var selectedVariantId = currentConditionDiv.find(".variant-select").val();
    var productId = $('input[type="radio"][name="products"]:checked').val();
    var button = $(this);
    $.ajax({
      url: variantsUrl,
      type: "GET",
      data: {
        productId: productId,
        excludeVariantId: selectedVariantId,
        context: "action",
        conditionIndex: conditionIndex, // Invia l'indice della condizione
        actionIndex: actionIndex, // Invia l'indice dell'azione
      },
      success: function (response) {
        conditionActionDiv.show();
        conditionActionDiv.append(response.html);
      },
      error: function (error) {
        console.log(error);
        alert("Errore nel recupero delle varianti.");
      },
    });
  });

  $("#conditionFields").on("change", ".shutdown-variant-select", function () {
    var selectedVariantId = $(this).val();
    var productId = $('input[type="radio"][name="products"]:checked').val();
    var currentShutdownActionDiv = $(this).closest(".shutdown-action-div");

    var conditionIndex = currentShutdownActionDiv
      .closest(".condition-div")
      .data("condition-index");
    var actionIndex = currentShutdownActionDiv.data("action-index");

    if (selectedVariantId) {
      var updateSuccess = updateActionSelectedVariants(
        conditionIndex,
        actionIndex,
        selectedVariantId
      );
      if (!updateSuccess) {
        // Se la variante è già stata selezionata in un'altra condizione, resetta la select
        $(this).val("").trigger("change");
        return;
      }

      currentShutdownActionDiv.find(".shutdown-value-select-div").remove();
      $.ajax({
        url: variantValuesUrl,
        type: "GET",
        data: {
          productId: productId,
          variantId: selectedVariantId,
          context: "action",
          conditionIndex: conditionIndex, // Includi l'indice della condizione nella richiesta
          actionIndex: actionIndex,
        },
        success: function (response) {
          currentShutdownActionDiv.append(response.html);
        },
        error: function (error) {
          console.log(error);
          alert("Errore nel recupero dei valori varianti.");
        },
      });
    }
  });

  $("#conditionFields")
    .on("show.bs.collapse", ".collapse", function () {
      $(this)
        .parent()
        .find(".btn-link i.fa-chevron-down")
        .removeClass("fa-chevron-down")
        .addClass("fa-chevron-up");
    })
    .on("hide.bs.collapse", ".collapse", function () {
      $(this)
        .parent()
        .find(".btn-link i.fa-chevron-up")
        .removeClass("fa-chevron-up")
        .addClass("fa-chevron-down");
    });
});

document.addEventListener("DOMContentLoaded", function () {
  // Verifica se l'elemento esiste
  var searchProductsElement = document.getElementById("searchProducts");

  if (searchProductsElement) {
    searchProductsElement.addEventListener("keyup", function () {
      let input = this;
      let filter = input.value.toUpperCase();
      let productsContainer = document.getElementById("products");

      // Verifica anche se productsContainer esiste per prevenire errori
      if (productsContainer) {
        let productDivs = productsContainer.querySelectorAll(".mb-3");

        productDivs.forEach(function (productDiv) {
          let productLabel = productDiv.querySelector(".form-check-label");

          // Assicurati che productLabel esista prima di tentare di accedere a textContent o innerText
          if (productLabel) {
            let productName =
              productLabel.textContent || productLabel.innerText;
            productDiv.style.display = productName
              .toUpperCase()
              .includes(filter)
              ? ""
              : "none";
          }
        });
      }
    });
  }

  const conditionFieldsContainer = document.querySelector("#conditionFields");
if (conditionFieldsContainer) {
    conditionFieldsContainer.addEventListener("click", function (e) {
        let deleteConditionButton = e.target.closest(".delete-condition");
        if (deleteConditionButton) {
            e.preventDefault();
            if (confirm("Sei sicuro di voler eliminare questa condizione e tutte le azioni associate? Questa azione non può essere annullata.")) {
                // Ottieni l'indice della condizione da eliminare
                let conditionDiv = deleteConditionButton.closest(".condition-div");
                let conditionIndex = conditionDiv.getAttribute("data-condition-index");
                removeCondition(conditionIndex); // Aggiorna lo stato
                conditionDiv.remove(); // Rimuove visivamente la condizione
            }
        }

        let deleteActionButton = e.target.closest(".delete-action");
        if (deleteActionButton) {
            e.preventDefault();
            if (confirm("Sei sicuro di voler eliminare questa azione?")) {
                // Ottieni gli indici necessari per identificare univocamente l'azione
                let actionDiv = deleteActionButton.closest(".shutdown-action-div");
                let conditionDiv = deleteActionButton.closest(".condition-div");
                let conditionIndex = conditionDiv.getAttribute("data-condition-index") // Assumendo che il div parent abbia l'attributo data-condition-index
                let actionIndex = actionDiv.getAttribute("data-action-index");
                removeAction(conditionIndex, actionIndex); // Aggiorna lo stato
                actionDiv.remove(); // Rimuove visivamente l'azione
            }
        }
    });
}
});



// Funzione per duplicare una condizione
function duplicateCondition(conditionDiv) {
  var collapsingElementOriginal = conditionDiv.find('.collapse');
  if (collapsingElementOriginal.length === 0) {
      console.error("Elemento .collapsing non trovato nella condizione originale");
      return;
  }

  // Clona l'elemento senza eventi per mantenere la struttura originale
  var newConditionDiv = conditionDiv.clone(false);
  var conditionIndex = generateUniqueConditionIndex();

  newConditionDiv.attr("data-condition-index", conditionIndex);
  newConditionDiv.find("[name^='condition']").each(function () {
      var name = $(this).attr("name");
      var newName = name.replace(/\d+/, conditionIndex);
      $(this).attr("name", newName);

      if ($(this).hasClass("variant-value-select")) {
          $(this).val("");
      }
  });

  // Aggiorna ID e aria-labelledby per il collapse
  var collapsingElement = newConditionDiv.find('.collapse');
  var collapseId = 'collapse' + conditionIndex;
  var headingId = 'heading' + conditionIndex;

  collapsingElement.attr('id', collapseId);
  collapsingElement.attr('aria-labelledby', headingId);

  var headingElement = newConditionDiv.find('.card-header');
  headingElement.attr('id', headingId);

  var buttonElement = headingElement.find('button');
  buttonElement.attr('data-bs-target', '#' + collapseId);
  buttonElement.attr('aria-controls', collapseId);

  // Aggiorna solo il testo del pulsante senza rimuovere le icone
  buttonElement.contents().filter(function() {
      return this.nodeType === 3; // Node.TEXT_NODE
  }).first().replaceWith('Condizione ' + (conditionIndex + 1) + ' ');

  newConditionDiv.find(".collapsing").removeClass("show");
  newConditionDiv.find(".fa-chevron-up").removeClass("fa-chevron-up").addClass("fa-chevron-down");
  $("#conditionFields").append(newConditionDiv);

  rebindConditionEvents(newConditionDiv);
}

// Bind degli eventi iniziali
$(document).ready(function () {
  $("#conditionFields").on("click", ".duplicate-condition", function () {
      duplicateCondition($(this).closest(".condition-div"));
  });
});




