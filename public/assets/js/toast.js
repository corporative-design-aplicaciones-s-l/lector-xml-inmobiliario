if (window.location.search.includes('sent=1')) {
    setTimeout(() => {
        const url = new URL(window.location);
        url.searchParams.delete('sent');
        window.history.replaceState({}, '', url);
    }, 100)
}
