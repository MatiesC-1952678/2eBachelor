#ifndef UTIL_H
#define UTIL_H

#include <glu.h>

class Util
{
public:

    static void drawSolidSphere(GLdouble radius, GLint slices, GLint stacks)
    {
      GLUquadricObj* quadric = gluNewQuadric();

      gluQuadricDrawStyle(quadric, GLU_FILL);
      gluSphere(quadric, radius, slices, stacks);

      gluDeleteQuadric(quadric);
    }
};

#endif // UTIL_H
