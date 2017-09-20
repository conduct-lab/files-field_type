## Usage[](#usage)

This section will show you how to use the field type via API and in the view layer.


### Setting Values[](#usage/setting-values)

You can set the files field type value with an array of file's ID.

    $entry->example = [10, 11, 12];

You can also set the value with a collection of a files.

    $entry->example = $files;


### Basic Output[](#usage/basic-output)

The files field type always returns `null` or a '\Anomaly\FilesModule\File\FileCollection' containing `\Anomaly\FilesModule\File\Contract\FileInterface` instances.

###### Example

    $entry->example->first()->getName(); // example.jpg

###### Twig

    {{ entry.example.first().getName() }} // example.jpg


### Presenter Output[](#usage/presenter-output)

When accessing the field value from a decorated entry model the collection will contain instances of `\Anomaly\FilesModule\File\FilePresenter`.

###### Example

    $decorated->example->first()->path; // local://folder/file.ext

    $decorated->example->first()->url(); // /app/{application}/example/image.jpg

###### Twig

    {{ decorated.example.first().path }} // local://folder/file.ext

    {{ decorated.example.first().url }} // /app/{application}/example/image.jpg
