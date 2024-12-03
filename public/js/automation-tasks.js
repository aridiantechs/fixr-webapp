$(document).ready(function () {
    const nonRecurringFields = $("#non_recurring_task_fields_container");
    const recurringFields = $("#recurring_task_fields_container");

    // Function to clear input fields
    function clearFields(container) {
        container.find("input, select").each(function () {
            $(this).val(""); // Clear value for inputs and selects
        });
    }

    // Function to toggle visibility based on the selected radio button
    function toggleFields() {
        const selectedType = $('input[name="automation_type"]:checked').val();
        if (selectedType === "non_recurring") {
            nonRecurringFields.removeClass("d-none");
            recurringFields.addClass("d-none");
            clearFields(recurringFields); // Clear recurring fields
        } else if (selectedType === "recurring") {
            recurringFields.removeClass("d-none");
            nonRecurringFields.addClass("d-none");
            clearFields(nonRecurringFields); // Clear non-recurring fields
        }
    }

    // Call toggleFields on page load
    toggleFields();

    // Handle radio button change
    $('input[name="automation_type"]').on("change", function () {
        toggleFields();
    });
});
