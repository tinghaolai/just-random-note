## How flutter works

### Flutter framework

Flutter is A Dart framework provide Utility Functions and UI Element (Widget).

Dart is the programming language of Flutter.

Flutter SDK provide a set of Tools.

### View render

How flutter stay high equality between Android and iOS? Because flutter render view by itself.

For example: 

When Flutter use `ElevatedButton` widget,
instead of using native Android `widget Button` or native iOS `UIButton`,
Flutter will render a custom button by itself.

Flutter controls every pixel on the screen, 
which means not limit by platform or translation loss,
as a result: `Better control`!

### Skia render engine

But how Flutter render view by itself actually?

It uses `Skia` render engine. 
> C++ 2D graphic engine, making sure render effect is same on every platform.


**Dart vs Skia**

Dart is for UI, Skia is for render.

Dart structure UI element to `Skia` render engine,
then `Skia` render engine render GPU data to `OpenGL`.

### Flutter architectural Overview

from official site.

![Flutter architectural Overview](archdiagram.png)


### Layout

Every component render use tree structure,
render by `DFS`.

**Size**

During render,
Size of node is constraint by parent node,
when render itself,
it knows the size it should be.

**Position**

But how the position of this node is decided?
It's decided by parent node,
it will check the position control logic from child node,
and decide the position of child node.


### Relayout Boundary

Flutter use `Relayout Boundary` to control render range,
when the layout of some node is changed,
other nodes outside the boundary will not be affected.

### Layer

Layer order by DFS,
during render,
Same path from top to bottom will be render in same layer.

**Repaint Boundary**

In some cases,
some nodes originally shouldn't be the same layer,
but somehow they are in same layer,
might cause repaint with other irrelevant node,
so Flutter use `Repaint Boundary` to force it switch to new layer,
prevent influence other node.