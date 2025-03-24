<div>


</div>

<script>
    function openModal(alias, index) {
        Livewire.dispatch('showModal', {
            data: {
                alias: alias,
                params: {
                    pollIndex: index
                }
            },
        });
    }
</script>
