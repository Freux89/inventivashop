<script>
    "use strict";

    // toggle select all
    function toggleSelectAll($this) {
        $("input:checkbox").prop('checked', $this.checked);
    }

    // toggle Group all
    function toggleGroupAll($this) {
        $($this).parent().parent().parent().find("input:checkbox").prop('checked', $this
            .checked);
    }
</script>
