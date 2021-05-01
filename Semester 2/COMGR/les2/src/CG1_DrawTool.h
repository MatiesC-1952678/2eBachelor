// G1_DrawTool.h: interface for the CG1_DrawTool class.
//
//////////////////////////////////////////////////////////////////////

#if !defined(AFX_G1_DRAWTOOL_H__EAC1E35F_BAF4_4ECF_957A_D5DEF2B21C31__INCLUDED_)
#define AFX_G1_DRAWTOOL_H__EAC1E35F_BAF4_4ECF_957A_D5DEF2B21C31__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

#include <QObject>
#include <QRect>
#include "cg_Canvas.h"
#include "RGB_Color.h"
#include "CG1_Line.h"
#include "CG1_2DPolygon.h"

struct CG1_OutCode
{
	int all;
	int left;
	int right;
	int bottom;
	int top;
};

class CG1_DrawTool : public QObject 
{
	Q_OBJECT

public:
	void setCanvasRef(cg_Canvas* canvasRef)					{canvas = canvasRef;}
	void DrawData();
	void DrawDDALine(CG1_Line Line, RGB_Color color);
	void FillPolygon(CG1_2DPolygon *Polygon, RGB_Color color);
	void DrawAllCirclePoints(int Midx, int Midy, int x, int y, RGB_Color color);
	void DrawMidPointLine(CG1_Line Line, RGB_Color color);
	void DrawMidPointCircle(int Midx, int Midy, int radius, RGB_Color color);
	void DrawSecondOrderMidPointCircle(int Midx, int Midy, int radius, RGB_Color color);
	void DrawClipRectangle(RGB_Color color);
	void DrawPolygon(CG1_2DPolygon *Polygon, RGB_Color color);
	CG1_OutCode CompOutCode(float x, float y);
    bool CyrusBeckClip(CG1_Line* Line);
    bool CohenSutherLandClip(CG1_Line* Line);
    bool Inside(CG1_2DVector point, int EdgeNr, int value);
    void SutherlandHodgemanPolygonClip(CG1_2DPolygon *Polygon);
    CG1_2DVector GetIntersection(CG1_2DVector first, CG1_2DVector second, int EdgeNr, int Value);

	void ClipUp();
	void ClipDown();

	CG1_DrawTool();
	virtual ~CG1_DrawTool();

private:
	cg_Canvas* canvas;

    int ClipLeft;
    int ClipRight;
    int ClipTop;
    int ClipBottom;
    int Increment;

};

#endif // !defined(AFX_G1_DRAWTOOL_H__EAC1E35F_BAF4_4ECF_957A_D5DEF2B21C31__INCLUDED_)
