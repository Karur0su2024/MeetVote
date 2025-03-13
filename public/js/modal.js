function openModal(alias, index) {
    console.log(index);
    Livewire.dispatch('showModal', {
        data: {
            alias: alias,
            params: {
                publicIndex: index
            }
        },
    });
}


