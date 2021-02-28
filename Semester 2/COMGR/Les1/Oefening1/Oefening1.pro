QT       += core gui

greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

CONFIG += c++11

# You can make your code fail to compile if it uses deprecated APIs.
# In order to do so, uncomment the following line.
#DEFINES += QT_DISABLE_DEPRECATED_BEFORE=0x060000    # disables all the APIs deprecated before Qt 6.0.0

SOURCES += \
    main.cpp \
    CG1_2DVector.cpp \
    CG1_ActiveEdgeTable.cpp \
    CG1_Canvas.cpp \
    CG1_DrawTool.cpp \
    CG1_Edge.cpp \
    CG1_EdgeTable.cpp \
    CG1_EdgeTableRow.cpp \
    CG1_Line.cpp \
    CG1_Polygon.cpp \
    CG1_Window.cpp \
    RGB_Color.cpp \
    cg1oefeningen.cpp

HEADERS += \
    CG1_2DVector.h \
    CG1_ActiveEdgeTable.h \
    CG1_Canvas.h \
    CG1_DrawTool.h \
    CG1_Edge.h \
    CG1_EdgeTable.h \
    CG1_EdgeTableRow.h \
    CG1_Line.h \
    CG1_Polygon.h \
    CG1_Window.h \
    RGB_Color.h \
    cg1oefeningen.h

FORMS += \
    cg1oefeningen.ui

# Default rules for deployment.
qnx: target.path = /tmp/$${TARGET}/bin
else: unix:!android: target.path = /opt/$${TARGET}/bin
!isEmpty(target.path): INSTALLS += target
