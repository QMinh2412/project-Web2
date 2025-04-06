const product_author_input = document.querySelector('#product_author-input');
let product_author_input_value = product_author_input.value;

const product_author_container = document.querySelector('#product_author_container');

const product_author_suggestion_wrapper = document.querySelector('#product_author_suggestion_wrapper');

async function filterAuthors() {
    const query = product_author_input.value.trim();

    if (query.length > 0) {
        try {
            // Fetch suggestions from the server
            const response = await fetch(`?page=product&action=authorSuggestion&name=${encodeURIComponent(query)}`);
            const authors = await response.json();

            let suggestionList = [];
            suggestionList = authors.filter(author => author.name.toLowerCase().includes(query.toLowerCase()));
            showAuthors(suggestionList);
        } catch (error) {
            console.error('Error fetching author suggestions:', error);
        }
    } else {
        // Clear suggestions if input is empty
        product_author_suggestion_wrapper.innerHTML = '';
    }
}

function showAuthors(suggestionList) {
    product_author_suggestion_wrapper.innerHTML = ''; // Clear previous suggestions

    suggestionList.forEach((suggestionItem) => {
        const li = document.createElement('div');
        li.classList.add('suggestion-item');
        li.textContent = suggestionItem;

        // Add click event to auto-fill the input
        li.addEventListener('click', () => {
            product_author_input.value = suggestionItem;
            product_author_suggestion_wrapper.innerHTML = ''; // Clear suggestions
        });

        product_author_suggestion_wrapper.appendChild(li);
    });
}

product_author_input.addEventListener('keyup', filterAuthors);
