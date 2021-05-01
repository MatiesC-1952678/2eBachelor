#include "CG1_DrawTool.h"
#include "CG1_2DVector.h"
#include "CG1_EdgeTable.h"
#include "CG1_ActiveEdgeTable.h"
#include <stdio.h>

//--------------------------------------------------------------------

CG1_DrawTool::CG1_DrawTool()
{
	Increment  = 120;
    ClipLeft   = -Increment;
    ClipRight  = Increment;
    ClipTop    = Increment;
    ClipBottom = -Increment;

	//Camera_X = 0.0;
    //Camera_Y = 0.0;
    //Camera_Z = 150.0;
    //Scene_RotationY = 0.0;
}

//--------------------------------------------------------------------

CG1_DrawTool::~CG1_DrawTool()
{
	
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawData()
{
	canvas->clear();

	//INITIALISEER DE MODELVIEWMATRIX
	//INITIALISEER DE PROJECTIEMATRIX


	//ASSENSTELSEL TEKENEN
    CG1_4DVector start, end;
    start.SetXYZW(-100, 0, 0, 1);
    end.SetXYZW(100, 0, 0, 1);
    Draw3DLine(start, end, RGB_Color(1.0f, 0.0f, 0.0f));
    start.SetXYZW(0, 100, 0, 1);
    end.SetXYZW(0, -100, 0, 1);
    Draw3DLine(start, end, RGB_Color(0.0f, 1.0f, 0.0f));
    start.SetXYZW(0, 0, 100, 1);
    end.SetXYZW(0, 0, -100, 1);
    Draw3DLine(start, end, RGB_Color(0.0f, 0.0f, 1.0f));  
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawClipRectangle(RGB_Color color)
{
	DrawDDALine(CG1_Line(ClipLeft , ClipTop   , ClipRight, ClipTop)   , color);
	DrawDDALine(CG1_Line(ClipRight, ClipTop   , ClipRight, ClipBottom), color);
	DrawDDALine(CG1_Line(ClipRight, ClipBottom, ClipLeft , ClipBottom), color);
	DrawDDALine(CG1_Line(ClipLeft , ClipBottom, ClipLeft , ClipTop)   , color);
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawDDALine(CG1_Line Line, RGB_Color color)
{
	int x0 = Line.X0();
	int y0 = Line.Y0();
	int x1 = Line.X1();
	int y1 = Line.Y1();

	float dy, dx, m, x, y;

	dy = (float)(y1 - y0);
	dx = (float)(x1 - x0);
	m = dy / dx;

	if( m >= -1 && m <= 1)
	{
		//rc (m) tussen -1 en 1

		// delta == 1  => steeds van links naar rechts
		if(x0 > x1)
		{
			int temp;
			temp = x1;
			x1 = x0;
			x0 = temp;

			temp = y1;
			y1 = y0;
			y0 = temp;
		}


		y = (float)y0;
		for (x=(float)x0; x<=x1; x++)
		{
			canvas->putPixel((int)x, (int)(y + 0.5), color);
			y += m;
		}

	}
	else
	{
		// delta == 1  => steeds van onder naar boven

		if(y0 > y1)
		{
			int temp;
			temp = x1;
			x1 = x0;
			x0 = temp;

			temp = y1;
			y1 = y0;
			y0 = temp;
		}

		m = dx / dy;
		x = (float)x0;
		for (y=(float)y0; y<=y1; y++)
		{
			canvas->putPixel((int)(x + 0.5), (int)y, color);
			x += m;
		}
	}
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawMidPointLine(CG1_Line Line, RGB_Color color)
{

}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawMidPointCircle(int Midx, int Midy, int radius, RGB_Color color)
{

}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawSecondOrderMidPointCircle(int Midx, int Midy, int radius, RGB_Color color)
{

}


//--------------------------------------------------------------------

void CG1_DrawTool::ClipUp()
{
    Increment += 2;
    ClipLeft = -Increment;
    ClipRight = Increment;
    ClipTop = Increment;
    ClipBottom = -Increment;

	DrawData();
}

//--------------------------------------------------------------------

void CG1_DrawTool::ClipDown()
{
    if(Increment > 5)
    {
		Increment -= 2;
		ClipLeft = -Increment;
		ClipRight = Increment;
		ClipTop = Increment;
		ClipBottom = -Increment;

		DrawData();
    }
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawAllCirclePoints(int Midx, int Midy, int x, int y, RGB_Color color)
{
	canvas->putPixel( Midx + x , Midy + y , color);
	canvas->putPixel( Midx + y , Midy + x , color);
	canvas->putPixel( Midx + y , Midy + -x, color);
	canvas->putPixel( Midx + x , Midy + -y, color);
	canvas->putPixel( Midx + -x, Midy + -y, color);
	canvas->putPixel( Midx + -y, Midy + -x, color);
	canvas->putPixel( Midx + -y, Midy + x , color);
	canvas->putPixel( Midx + -x, Midy + y , color);
}

//--------------------------------------------------------------------

void CG1_DrawTool::FillPolygon(CG1_2DPolygon  *Polygon, RGB_Color color)
{
	if(Polygon->GetSize() > 0)
	{
		int MinimumY = Polygon->GetLowestY();
		int MaximumY = Polygon->GetHighestY();
		CG1_EdgeTable ET;
		CG1_ActiveEdgeTable AET;

		// ZELF VERDER IMPLEMENTEREN
	}
}

//--------------------------------------------------------------------

//--------------------------------------------------------------------

CG1_OutCode CG1_DrawTool::CompOutCode(float x, float y)
{
    CG1_OutCode code;
    
    code.all = 0;
    //all: 4 bits ->     top = 8   ---   bottom = 4   ---   right = 2   ---   left = 1
    code.top = 0;
    code.bottom = 0;
    code.left = 0;
    code.right = 0;
    
    
    if(y > ClipTop)
    {
	code.top = 1;
	code.all += 8;	// eerste bit aanzetten
    }
    else if(y < ClipBottom)
    {
	code.bottom = 1;
	code.all += 4;	// tweede bit aanzetten
    }
    
    
    if(x > ClipRight)
    {
	code.right = 1;
	code.all += 2;	// derde bit aanzetten
    }
    else if(x < ClipLeft)
    {
	code.left = 1;
	code.all += 1;	// vierde bit aanzetten
    }
    
    
    return code;
}

//--------------------------------------------------------------------

bool CG1_DrawTool::CohenSutherLandClip(CG1_Line* Line)
{
	return 0;
}

//--------------------------------------------------------------------

bool CG1_DrawTool::CyrusBeckClip(CG1_Line* Line)
{
	float x0 = (float)Line->X0();
	float y0 = (float)Line->Y0();
	float x1 = (float)Line->X1();
	float y1 = (float)Line->Y1();

	CG1_2DVector P0, P1, D;
	P0.SetXY(x0, y0);
	P1.SetXY(x1, y1);
	D.SetXY(x1 - x0, y1 - y0);	

	CG1_OutCode OutCode0, OutCode1;
	float tE, tL, t, NiDotD;
	CG1_2DVector Ni, Pei, P0_Pei;

	OutCode0 = CompOutCode(x0, y0);
	OutCode1 = CompOutCode(x1, y1);

	if((OutCode0.all | OutCode1.all) == 0)					//triviaal aanvaard
	{
		Line->SetData(x0, y0, x1, y1);
		return true;
	}
	else if((OutCode0.all & OutCode1.all) != 0)					//triviaal geweigerd
	{
		return false;
	}
	else	//doe Cyrus-Beck
	{
		if(x0 - x1 <= 0.001 && x0 - x1 >= -0.001 && y0 - y1 <= 0.001 && y0 - y1 >= -0.001)
		{
			//begin- en eindpunt zijn gelijk
			return false;
		}
		else
		{

			tE = 0;
			tL = 1;

			for(int i=0; i<4; i++)		// vier kanten:		0 = onder | 1 = rechts | 2 = boven | 3 = links
			{
				switch(i)
				{
				case 0:	// onder
					{
						Ni.SetXY(0.0f, -1.0f);
						Pei.SetXY(ClipLeft, ClipBottom);
						break;
					}
				case 1:	// rechts
					{
						Ni.SetXY(1.0f, 0.0f);
						Pei.SetXY(ClipRight, ClipBottom);
						break;
					}
				case 2:	// boven
					{
						Ni.SetXY(0.0f, 1.0f);
						Pei.SetXY(ClipRight, ClipTop);
						break;
					}	
				case 3:	// links
					{
						Ni.SetXY(-1.0f, 0.0f);
						Pei.SetXY(ClipLeft, ClipTop);
						break;
					}
				}

				NiDotD = Ni * D;

				if(NiDotD != 0)						// anders loopt ze parallell met de edge
				{
					P0_Pei.SetXY( (P0.GetX() - Pei.GetX()), (P0.GetY() - Pei.GetY()) );

					// t berekenen:		t = (Ni * [P0 - Pei]) / (-Ni * D)
					t = (Ni * P0_Pei) / (-Ni * D);

					if(NiDotD > 0)	// => PL
					{
						if(t < tL)
							tL = t;
					}
					else			// => PE
					{
						if(t > tE)
							tE = t;
					}
				}

			}

			if(tE < tL)
			{
				// draw the line
				CG1_2DVector PtE, PtL;
				PtE.SetXY( ( P0.GetX() + (tE * D.GetX()) ), ( P0.GetY() + (tE * D.GetY()) ) );
				PtL.SetXY( ( P0.GetX() + (tL * D.GetX()) ), ( P0.GetY() + (tL * D.GetY()) ) );

				Line->SetData((int)PtE.GetX(), (int)PtE.GetY(), (int)PtL.GetX(), (int)PtL.GetY());
				return true;
			}
			else
			{
				return false;
			}

		}

	}

	//return 0;
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawPolygon(CG1_2DPolygon *Polygon, RGB_Color color)
{
    int NrOfPoints = Polygon->GetSize();
    CG1_2DVector FirstPoint;
    CG1_2DVector SecondPoint;
    FirstPoint = Polygon->GetPoint(0);
    for(int i=1; i<NrOfPoints; i++)
    {
	SecondPoint = Polygon->GetPoint(i);
	CG1_Line CurrentEdge;
	CurrentEdge.SetData(FirstPoint.GetX(), FirstPoint.GetY(), SecondPoint.GetX(), SecondPoint.GetY());
	DrawMidPointLine(CurrentEdge, color);
	FirstPoint = SecondPoint;
    }
    SecondPoint = Polygon->GetPoint(0);
    CG1_Line CurrentEdge;
    CurrentEdge.SetData(FirstPoint.GetX(), FirstPoint.GetY(), SecondPoint.GetX(), SecondPoint.GetY());
    DrawMidPointLine(CurrentEdge, color);
}

//--------------------------------------------------------------------

void CG1_DrawTool::SutherlandHodgemanPolygonClip(CG1_2DPolygon *Polygon)
{
    
}

//--------------------------------------------------------------------

bool CG1_DrawTool::Inside(CG1_2DVector point, int EdgeNr, int value)
{
    switch(EdgeNr)
    {
	case 0:						// onder
	{
	    if(point.GetY() > value)
		return true;
	    else
		return false;
	    break;
	}
	case 1:						// rechts
	{
	    if(point.GetX() < value)
		return true;
	    else
		return false;
	    break;
	}
	case 2:						// boven 
	{
	    if(point.GetY() < value)
		return true;
	    else
		return false;
	    break;
	}
	case 3:						// links
	{
	    if(point.GetX() > value)
		return true;
	    else
		return false;
	    break;
	}
	default:
	{
	    return false;
	    break;
	}
    }
}

//--------------------------------------------------------------------

CG1_2DVector CG1_DrawTool::GetIntersection(CG1_2DVector first, CG1_2DVector second, int EdgeNr, int Value)
{
    float x0 = first.GetX();
    float y0 = first.GetY();
    float x1 = second.GetX();
    float y1 = second.GetY();
    
    float x = 0.0f;
    float y = 0.0f;
    
    if(EdgeNr == 0)								// intersectie met onderkant berekenen
    {
	x = x0 + ((x1 - x0) * ((Value - y0) / (y1 - y0)));
	y = Value;
    }
    else if(EdgeNr == 1)						// intersectie met rechterkant berekenen
    {
	y = y0 + ((y1 - y0) * ((Value - x0) / (x1 - x0)));
	x = Value;
    }
    else if(EdgeNr == 2)						// intersectie met bovenkant berekenen
    {
	x = x0 + ((x1 - x0) * ((Value - y0) / (y1 - y0)));
	y = Value;
    }
    else if(EdgeNr == 3)						// intersectie met linkerkant berekenen
    {
	y = y0 + ((y1 - y0) * ((Value - x0) / (x1 - x0)));
	x = Value;
    }
    
    CG1_2DVector ReturnVector;
    ReturnVector.SetXY(x, y);
    
    return ReturnVector;
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawUnitCube(RGB_Color color)
{
	CG1_4DVector Start;
	CG1_4DVector End;

	Start.SetXYZW(-0.5, -0.5,  0.5, 1.0);	//0
	End.SetXYZW(  -0.5,  0.5,  0.5, 1.0);	//1
	Draw3DLine(Start, End, color);
	Start.SetXYZW(-0.5,  0.5,  0.5, 1.0);	//1
	End.SetXYZW(   0.5,  0.5,  0.5, 1.0);	//2
	Draw3DLine(Start, End, color);
	Start.SetXYZW( 0.5,  0.5,  0.5, 1.0);	//2
	End.SetXYZW(   0.5, -0.5,  0.5, 1.0);	//3
	Draw3DLine(Start, End, color);
	Start.SetXYZW( 0.5, -0.5,  0.5, 1.0);	//3
	End.SetXYZW(  -0.5, -0.5,  0.5, 1.0);	//0
	Draw3DLine(Start, End, color);			//							5		6

	Start.SetXYZW(-0.5, -0.5, -0.5, 1.0);	//4
	End.SetXYZW(  -0.5,  0.5, -0.5, 1.0);	//5
	Draw3DLine(Start, End, color);			//							4		7
	Start.SetXYZW(-0.5,  0.5, -0.5, 1.0);	//5				1		2
	End.SetXYZW(   0.5,  0.5, -0.5, 1.0);	//6
	Draw3DLine(Start, End, color);
	Start.SetXYZW( 0.5,  0.5, -0.5, 1.0);	//6
	End.SetXYZW(   0.5, -0.5, -0.5, 1.0);	//7				0		3
	Draw3DLine(Start, End, color);
	Start.SetXYZW( 0.5, -0.5, -0.5, 1.0);	//7
	End.SetXYZW(  -0.5, -0.5, -0.5, 1.0);	//4
	Draw3DLine(Start, End, color);

	Start.SetXYZW(-0.5, -0.5,  0.5, 1.0);	//0
	End.SetXYZW(  -0.5, -0.5, -0.5, 1.0);	//4
	Draw3DLine(Start, End, color);
	Start.SetXYZW(-0.5,  0.5,  0.5, 1.0);	//1
	End.SetXYZW(  -0.5,  0.5, -0.5, 1.0);	//5
	Draw3DLine(Start, End, color);
	Start.SetXYZW( 0.5,  0.5,  0.5, 1.0);	//2
	End.SetXYZW(   0.5,  0.5, -0.5, 1.0);	//6
	Draw3DLine(Start, End, color);
	Start.SetXYZW( 0.5, -0.5,  0.5, 1.0);	//3
	End.SetXYZW(   0.5, -0.5, -0.5, 1.0);	//7
	Draw3DLine(Start, End, color);

}

//--------------------------------------------------------------------

void CG1_DrawTool::Draw3DLine(CG1_4DVector start, CG1_4DVector end, RGB_Color color)
{
	/*start = ModelViewMatrix * start;
	end = ModelViewMatrix * end;

	start = ProjectionMatrix * start;
	end = ProjectionMatrix * end;

	start.DivideByW();
	end.DivideByW();

	CG1_Line The_Line = CG1_Line((int)start.GetX(), (int)start.GetY(), (int)end.GetX(), (int)end.GetY());

	if(CyrusBeckClip(&The_Line))
		DrawDDALine(The_Line, color);
	*/
}

//--------------------------------------------------------------------

void CG1_DrawTool::PushMatrix()
{
	//MatrixStack.push(ModelViewMatrix);
}

//--------------------------------------------------------------------

void CG1_DrawTool::PopMatrix()
{
	/*if(MatrixStack.size() > 0)
	{
		ModelViewMatrix = MatrixStack.top();
		MatrixStack.pop();
	}*/
}

//--------------------------------------------------------------------

void CG1_DrawTool::ModifyView(char axe, int amount)
{
	/*switch(axe)
		{
		case 'x':	
			Camera_X += amount;
			break;
		case 'y':	
			Camera_Y += amount;
			break;
		case 'z':	
			Camera_Z += amount;
			break;	
		case 'r':	
			Scene_RotationY += amount;
			break;
	}*/
}
