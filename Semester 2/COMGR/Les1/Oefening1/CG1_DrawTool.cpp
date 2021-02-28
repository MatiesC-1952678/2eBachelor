// G1_DrawTool.cpp: implementation of the CG1_DrawTool class.
//
//////////////////////////////////////////////////////////////////////

#include "CG1_DrawTool.h"
#include "CG1_2DVector.h"
#include "CG1_EdgeTable.h"
#include "CG1_ActiveEdgeTable.h"
#include <stdio.h>

//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////
//--------------------------------------------------------------------

CG1_DrawTool::CG1_DrawTool()
{
}

//--------------------------------------------------------------------

CG1_DrawTool::~CG1_DrawTool()
{
	
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawData()
{
	// HIER KAN JE AANGEVEN WAT GETEKEND MOET WORDEN
	// (= FUNCTIES AANROEPEN DIE BEPAALDE DINGEN TEKENEN )

	// VOORBEELDEN:
    DrawDDALine(CG1_Line(10,10,50,100), RGB_Color(1.0,0.0,0.0));
    //DrawDDALine(CG1_Line(10,40,100,55), RGB_Color(1.0,0.0,0.0));
    //DrawDDALine(CG1_Line(10,100,50,10), RGB_Color(1.0,0.0,0.0)); //moet tussen 0 en 1 liggen dus natuurlijk kan deze niet stijler gaan dan 1
    //DrawMidPointLine(CG1_Line(-10,-10,50,100), RGB_Color(1.0,0.0,0.0));
    DrawMidPointCircle(10,10, 50, RGB_Color(0.0,0.0,1.0));
    DrawSecondOrderMidPointCircle(-10,10, 50, RGB_Color(0.0,1.0,0.0));
	
    CG1_Polygon MyPolygon;
    MyPolygon.AddPoint(CG1_2DVector(55.0, 50.0));
    MyPolygon.AddPoint(CG1_2DVector(100.0, 15.0));
    MyPolygon.AddPoint(CG1_2DVector(25.0, -5.0));
    MyPolygon.AddPoint(CG1_2DVector(20.0, 5.0));
    MyPolygon.AddPoint(CG1_2DVector(-10.0, -5.0));


    FillPolygon(&MyPolygon, RGB_Color(0.0,1.0,1.0));
    UpdateWindow();
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawDDALine(CG1_Line Line, RGB_Color color)
{
    // begin en eindpunt van de Line (x is begin, y is eind)
    int x0 = Line.X0();
    int y0 = Line.Y0();
    int x1 = Line.X1();
    int y1 = Line.Y1();

    //DDA ALGORITME
    int x; float y, m;
    m = (y1 - y0) / (x1 - x0);
    y = y0;
    for (x = x0; x <= x1; x++) {
        emit PutPixel (x, (int) floor (y + 0.5), color);
        y += m;
    }

   
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawMidPointLine(CG1_Line Line, RGB_Color color) {
    int x0 = Line.X0();
    int y0 = Line.Y0();
    int x1 = Line.X1();
    int y1 = Line.Y1();

    //MIDPOINT ALGORITME
    int dx, dy, incrE, incrNE, d, x, y;
    dy = y1 - y0;
    dx = x1 - x0;
    d = dy * 2 - dx;
    incrE = dy * 2;
    incrNE = (dy - dx) * 2;
    x = x0;
    y = y0;
    emit PutPixel(x, y, color);
    while (x < x1) {
        if (d <= 0)
            d += incrE;
        else {
            d += incrNE;
            y++;
        }
        x++;
        emit PutPixel(x, y, color);
    }
}

void CG1_DrawTool::DrawAllCirclePoints(int Midx, int Midy, int x, int y, RGB_Color color)
{
	PutPixel( Midx + x , Midy + y , color);
	PutPixel( Midx + y , Midy + x , color);
	PutPixel( Midx + y , Midy + -x, color);
	PutPixel( Midx + x , Midy + -y, color);
	PutPixel( Midx + -x, Midy + -y, color);
	PutPixel( Midx + -y, Midy + -x, color);
	PutPixel( Midx + -y, Midy + x , color);
	PutPixel( Midx + -x, Midy + y , color);
}

void CG1_DrawTool::DrawMidPointCircle(int Midx, int Midy, int radius, RGB_Color color) {
    int d, x, y;
    x = 0;
    y = radius;
    d = 1 - radius;
    DrawAllCirclePoints(Midx, Midy, x, y, color);
    while (y > x) {
        if (d < 0)
            d += x * 2 + 3;
        else {
            d += (x - y) * 2 + 5;
            y--;
        }
        x++;
        DrawAllCirclePoints(Midx, Midy, x, y, color);
    }
}

void CG1_DrawTool::DrawSecondOrderMidPointCircle(int Midx, int Midy, int radius, RGB_Color color) {
    int     x, y, d, deltaE, deltaSE;
    //https://www.csee.umbc.edu/~rheingan/435/pages/res/gen-3.Circles-single-page-0.html
    x = 0;
    y = radius;
    d = 1 - radius;
    deltaE = 2;
    deltaSE = 5 - radius * 2;

    DrawAllCirclePoints(Midx, Midy, x, y, color);
    while ( y > x ) {
        if ( d < 0 ) { /* Select E */
            d       += deltaE;
            deltaE  += 2;
            deltaSE += 2;
            x--;
        }
        else {         /* Select SE */
            d       += deltaSE;
            deltaE  += 2;
            deltaSE += 4;
            x++;
            y--; //++ dan gaat je cirkel raar convergeren
        }
      DrawAllCirclePoints(Midx, Midy, x, y, color);
   }
}

//--------------------------------------------------------------------

void CG1_DrawTool::FillPolygon(CG1_Polygon *Polygon, RGB_Color color)
{
	if(Polygon->GetSize() > 0)
	{
		int MinimumY = Polygon->GetLowestY();
		int MaximumY = Polygon->GetHighestY();
        CG1_EdgeTable ET;
		CG1_ActiveEdgeTable AET;
        ET.Initialize(Polygon);

        int i = 0;
        while (ET.GetEdgeTableRow(i) != nullptr) {
            printf("%n", &i);
            i++;
        }
	}
}

//--------------------------------------------------------------------
