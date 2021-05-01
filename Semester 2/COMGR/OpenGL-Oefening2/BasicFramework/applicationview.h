#ifndef APPLICATIONVIEW_H
#define APPLICATIONVIEW_H

#include <QOpenGLWidget>
#include <QTimer>
#include <QKeyEvent>

class ApplicationView : public QOpenGLWidget
{
    Q_OBJECT
public:
    ApplicationView(QWidget *parent=0);
    void changeCam(float posX, float posY, float posZ, float lookAtX, float lookAtY, float lookAtZ, float upX, float upY, float upZ);

    void togglePlayable();
    bool getPlayable();
protected:
    void initializeGL ();
    void resizeGL ( int width, int height );
    void paintGL ();

    void keyPressEvent(QKeyEvent * e);
private:

    int secondsPassed;
    double camPosx,camPosy,camPosz;
    double camUpx,camUpy,camUpz;
    double camViewx,camViewy,camViewz;
    QTimer* timer;

    bool isPlayable;
    enum DIRECTION {NORTH, EAST, SOUTH, WEST};
    DIRECTION currentDirection = NORTH;

    void movePlayer( QKeyEvent * e );
    void moveCamera( QKeyEvent * e );
    void updateLookingDirection(int incr);
    void turnLeft();
    void turnRight();
};

#endif // APPLICATIONVIEW_H
