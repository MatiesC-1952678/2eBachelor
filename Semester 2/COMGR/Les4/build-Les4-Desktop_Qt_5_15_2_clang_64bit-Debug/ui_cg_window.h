/********************************************************************************
** Form generated from reading UI file 'cg_window.ui'
**
** Created by: Qt User Interface Compiler version 5.15.2
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_CG_WINDOW_H
#define UI_CG_WINDOW_H

#include <QtCore/QVariant>
#include <QtWidgets/QApplication>
#include <QtWidgets/QFrame>
#include <QtWidgets/QHBoxLayout>
#include <QtWidgets/QMainWindow>
#include <QtWidgets/QMenuBar>
#include <QtWidgets/QPushButton>
#include <QtWidgets/QSpacerItem>
#include <QtWidgets/QStatusBar>
#include <QtWidgets/QVBoxLayout>
#include <QtWidgets/QWidget>
#include "cg_Canvas.h"

QT_BEGIN_NAMESPACE

class Ui_CG_Window
{
public:
    QWidget *centralwidget;
    QVBoxLayout *vboxLayout;
    QFrame *frame_buttons;
    QHBoxLayout *hboxLayout;
    QPushButton *pushButton_Save;
    QSpacerItem *spacerItem;
    QPushButton *pushButton_ClipUp;
    QWidget *widget;
    QPushButton *pushButton_ClipDown;
    cg_Canvas *drawCanvas;
    QMenuBar *menubar;
    QStatusBar *statusbar;

    void setupUi(QMainWindow *CG_Window)
    {
        if (CG_Window->objectName().isEmpty())
            CG_Window->setObjectName(QString::fromUtf8("CG_Window"));
        CG_Window->resize(480, 480);
        centralwidget = new QWidget(CG_Window);
        centralwidget->setObjectName(QString::fromUtf8("centralwidget"));
        vboxLayout = new QVBoxLayout(centralwidget);
        vboxLayout->setObjectName(QString::fromUtf8("vboxLayout"));
        frame_buttons = new QFrame(centralwidget);
        frame_buttons->setObjectName(QString::fromUtf8("frame_buttons"));
        frame_buttons->setFrameShape(QFrame::StyledPanel);
        frame_buttons->setFrameShadow(QFrame::Raised);
        hboxLayout = new QHBoxLayout(frame_buttons);
        hboxLayout->setObjectName(QString::fromUtf8("hboxLayout"));
        pushButton_Save = new QPushButton(frame_buttons);
        pushButton_Save->setObjectName(QString::fromUtf8("pushButton_Save"));

        hboxLayout->addWidget(pushButton_Save);

        spacerItem = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        hboxLayout->addItem(spacerItem);

        pushButton_ClipUp = new QPushButton(frame_buttons);
        pushButton_ClipUp->setObjectName(QString::fromUtf8("pushButton_ClipUp"));

        hboxLayout->addWidget(pushButton_ClipUp);

        widget = new QWidget(frame_buttons);
        widget->setObjectName(QString::fromUtf8("widget"));

        hboxLayout->addWidget(widget);

        pushButton_ClipDown = new QPushButton(frame_buttons);
        pushButton_ClipDown->setObjectName(QString::fromUtf8("pushButton_ClipDown"));

        hboxLayout->addWidget(pushButton_ClipDown);


        vboxLayout->addWidget(frame_buttons);

        drawCanvas = new cg_Canvas(centralwidget);
        drawCanvas->setObjectName(QString::fromUtf8("drawCanvas"));
        QSizePolicy sizePolicy(QSizePolicy::Expanding, QSizePolicy::Expanding);
        sizePolicy.setHorizontalStretch(0);
        sizePolicy.setVerticalStretch(0);
        sizePolicy.setHeightForWidth(drawCanvas->sizePolicy().hasHeightForWidth());
        drawCanvas->setSizePolicy(sizePolicy);
        drawCanvas->setFocusPolicy(Qt::StrongFocus);

        vboxLayout->addWidget(drawCanvas);

        CG_Window->setCentralWidget(centralwidget);
        menubar = new QMenuBar(CG_Window);
        menubar->setObjectName(QString::fromUtf8("menubar"));
        menubar->setGeometry(QRect(0, 0, 480, 24));
        CG_Window->setMenuBar(menubar);
        statusbar = new QStatusBar(CG_Window);
        statusbar->setObjectName(QString::fromUtf8("statusbar"));
        CG_Window->setStatusBar(statusbar);

        retranslateUi(CG_Window);

        QMetaObject::connectSlotsByName(CG_Window);
    } // setupUi

    void retranslateUi(QMainWindow *CG_Window)
    {
        CG_Window->setWindowTitle(QCoreApplication::translate("CG_Window", "Computer Graphics", nullptr));
        pushButton_Save->setText(QCoreApplication::translate("CG_Window", "Save", nullptr));
        pushButton_ClipUp->setText(QCoreApplication::translate("CG_Window", "Clip Up", nullptr));
        pushButton_ClipDown->setText(QCoreApplication::translate("CG_Window", "Clip Down", nullptr));
    } // retranslateUi

};

namespace Ui {
    class CG_Window: public Ui_CG_Window {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_CG_WINDOW_H
