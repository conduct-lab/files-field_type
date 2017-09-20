## Introduction[](#introduction)

`anomaly.field_type.files`

The files field type provides a configurable uploader and multiple selection lookup for files from the Files module.


### Configuration[](#introduction/configuration)

Below is a list of available configuration with default values:

    "example" => [
        "type"   => "anomaly.field_type.files",
        "config" => [
            "folders"  => [],
            "max_size" => null,
            "min"      => null,
            "max"      => null,
            "mode"     => "default",
        ]
    ]

###### Configuration

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Example</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

folders

</td>

<td>

`["images", "slides"]`

</td>

<td>

The slugs, paths, or IDs of allowed file folders. Defaults to all folders.

</td>

</tr>

<tr>

<td>

max_size

</td>

<td>

10

</td>

<td>

The max size in megabytes allowed for uploads. Defaults to folder configured max then server max.

</td>

</tr>

<tr>

<td>

min

</td>

<td>

5

</td>

<td>

The minimum number of selections allowed.

</td>

</tr>

<tr>

<td>

max

</td>

<td>

5

</td>

<td>

The maximum number of selections allowed.

</td>

</tr>

<tr>

<td>

mode

</td>

<td>

`default`

</td>

<td>

The user input mode. Available options are `default`, `select`, or `upload`.

</td>

</tr>

</tbody>

</table>
