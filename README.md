# serben-films

A beautiful way to see your film library.

Simple to install, works out of the box, looks awesome.

Why are you still reading this? Grab your copy now!

## Setup

**serben-films** needs a running PHP server. Once you have that, you should be done.

## Configuration

**serben-films** works by scanning the provided directory, and listing all the videos that have been found.
Specify where the films are located (`root`) and what URL to use when listing the links (`link`) in `config.json`.

`config.json` sample:
```shell
{
	"root" : "/root/to/somewhere",
	"link" : "http://your.domain.here/films/directory"
}
```

## Customization
In order to set a cover image for a film, just place the desired image in the same folder where the video file is, named as `cover.png` (`cover.jpg`).
The title of a film is based on its filename, but it can be set using a `cover.json` file. This file can be placed in any directory under your `root`. All subdirectories will use the closest `cover.json` file.

`cover.json` should have the following syntax:

```shell
{
	"title" : "Sample title",
	"image" : "cover.jpg",
	"language" : "en",
	"rating" : "10"
}
```
Not all the fields are required.

## Coded by:

- Oanca Andrei <oancaionutandrei@gmail.com>
