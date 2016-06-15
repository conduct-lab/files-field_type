# Usage

This field type returns a file collection instance as a value. You may access the collection and it's items as normal.

**Examples:**

    // Twig usage
    {% verbatim %}
    {% for file in entry.example %}
        File {{ loop.index }} is a {{ file.mime_type }}.
    {% endfor %}
    {% endverbatim %}
    
    // API usage
    foreach ($entry->example as $k => $file) {
        echo "File {$k} is a {$file->getMimeType()}";
    }
