<div>


</div>

<script>
    function openModal(alias, index) {
        Livewire.dispatch('showModal', {
            data: {
                alias: alias,
                params: {
                    pollId: index
                }
            },
        });
    }
</script>
