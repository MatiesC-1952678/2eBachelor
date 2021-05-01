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

	Camera_X = 0.0;
	Camera_Y = 0.0;
	Camera_Z = 150.0;
	Scene_RotationY = 0.0;
}

//--------------------------------------------------------------------

CG1_DrawTool::~CG1_DrawTool()
{
	
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawData()
{
	canvas->clear();

	// HIER KAN JE AANGEVEN WAT GETEKEND MOET WORDEN
    DrawClipRectangle(RGB_Color(0.0, 0.0, 0.0));

    ProjectionMatrix.LoadIdentity();
    ProjectionMatrix.SetPerspectiveProjection(-120);
    
    ModelViewMatrix.LoadIdentity();
    ModelViewMatrix.Translate(-Camera_X, -Camera_Y, -Camera_Z);
    ModelViewMatrix.RotateY(Scene_RotationY);
    
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



	//NIET 3D!!! => niet onderhevig aan matrices
	/*
	CG1_2DPolygon poly1;
	poly1.AddPoint(CG1_2DVector(0.0f, 0.0f));
	poly1.AddPoint(CG1_2DVector(5.0f, 10.0f));
	poly1.AddPoint(CG1_2DVector(10.0f, 0.0f));

	SutherlandHodgemanPolygonClip(&poly1);
	FillPolygon(&poly1, RGB_Color(1.0f, 0.0f, 0.0f));
	*/
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawClipRectangle(RGB_Color color)
{
	DrawMidPointLine(CG1_Line(ClipLeft , ClipTop   , ClipRight, ClipTop)   , color);
	DrawMidPointLine(CG1_Line(ClipRight, ClipTop   , ClipRight, ClipBottom), color);
	DrawMidPointLine(CG1_Line(ClipRight, ClipBottom, ClipLeft , ClipBottom), color);
	DrawMidPointLine(CG1_Line(ClipLeft , ClipBottom, ClipLeft , ClipTop)   , color);
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
	int x0 = Line.X0();
	int y0 = Line.Y0();
	int x1 = Line.X1();
	int y1 = Line.Y1();

	int dx, dy, IncrementToE, IncrementToN, IncrementToS, IncrementToSE, IncrementToNE, d, x, y;
	float m;				// 1 float om m juist te berekenen : per lijn 1 maal

	// steeds van links naar rechts tekenen.

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


	// het algoritme

	dy = y1 - y0;
	dx = x1 - x0;
	m = (float)dy / (float)dx;



	if(m >= -1 && m <= 1)
	{	
		if( m >= 0 )
		{
			//rc (m) tussen 0 en 1 (=> E en NE)

			d = (dy * 2) - dx;				// startwaarde
			IncrementToE = dy * 2;			// increment voor d, na verplaatsing naar E
			IncrementToNE = (dy - dx) * 2;	// increment voor d, na verplaatsing naar NE

			x = x0;
			y = y0;

			canvas->putPixel(x, y, color);		// eerste punt

			while(x < x1)
			{
				if(d <= 0)				// Naar E gaan
				{
					d += IncrementToE;
				}
				else					// Naar NE gaan
				{
					d += IncrementToNE;
					y++;
				}
				x++;

				canvas->putPixel(x, y, color);	// Teken nieuwe pixel
			}
		}
		else if (m < 0 )
		{
			//rc (m) tussen 0 en -1 (=> E en SE)

			d = (dy * 2) + dx;				// startwaarde
			IncrementToE = dy * 2;			// increment voor d, na verplaatsing naar E
			IncrementToSE = (dy + dx) * 2;	// increment voor d, na verplaatsing naar SE

			x = x0;
			y = y0;

			canvas->putPixel(x, y, color);		// eerste punt

			while(x < x1)
			{
				if(d <= 0)				// Naar SE gaan
				{
					d += IncrementToSE;
					y--;
				}
				else					// Naar E gaan
				{
					d += IncrementToE;
				}
				x++;

				canvas->putPixel(x, y, color);	// Teken nieuwe pixel
			}
		}

	}

	else
	{	
		// m > 1 of m < -1

		if (m > 1)
		{
			//rc (m) groter dan 1 (=> N en NE)

			d = dy - (dx * 2);				// startwaarde
			IncrementToN = -(dx * 2);		// increment voor d, na verplaatsing naar N
			IncrementToNE = (dy - dx) * 2;	// increment voor d, na verplaatsing naar NE

			x = x0;
			y = y0;

			canvas->putPixel(x, y, color);		// eerste punt

			while(y < y1)
			{
				if(d >= 0)				// Naar N gaan
				{
					d += IncrementToN;
				}
				else					// Naar NE gaan
				{
					d += IncrementToNE;
					x++;
				}
				y++;

				canvas->putPixel(x, y, color);	// Teken nieuwe pixel
			}
		}

		else if ( m < -1)
		{
			//rc (m) kleiner dan -1 (=> S en SE)

			d = dy + (dx * 2);				// startwaarde
			IncrementToS = (dx * 2);		// increment voor d, na verplaatsing naar S
			IncrementToSE = (dy + dx) * 2;	// increment voor d, na verplaatsing naar SE

			x = x0;
			y = y0;

			canvas->putPixel(x, y, color);	// eerste punt

			while(y > y1)
			{
				if(d <= 0)			// Naar S gaan
				{
					d += IncrementToS;
				}
				else				// Naar SE gaan
				{
					d += IncrementToSE;
					x++;
				}
				y--;

				canvas->putPixel(x, y, color);	// Teken nieuwe pixel
			}
		}
	}
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawMidPointCircle(int Midx, int Midy, int radius, RGB_Color color)
{
	int d, x, y;

	x = 0;											// initialiseren
	y = radius;
	d = 1 - radius;
	DrawAllCirclePoints(Midx, Midy, x, y, color);	// eerste punt

	while (y > x)									// voor 0.125 van de cirkel
	{
		if(d < 0)					// Naar E gaan
		{
			d += (x * 2) + 3;
		}
		else						// Naar SE gaan
		{
			d += ((x - y) * 2) + 5;
			y--;
		}
		x++;
		DrawAllCirclePoints(Midx, Midy, x, y, color);
	}
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawSecondOrderMidPointCircle(int Midx, int Midy, int radius, RGB_Color color)
{
	int d, x, y, deltaE, deltaSE;

	x = 0;
	y = radius;
	d = 1 - radius;
	deltaE = 3;										// initialiseren
	deltaSE = 5 - (radius * 2);
	DrawAllCirclePoints(Midx, Midy, x, y, color);

	while (y > x)									// voor 0.125 van de cirkel
	{
		if(d < 0)					// Naar E gaan
		{
			d += deltaE;
			deltaE += 2;
			deltaSE += 2;
		}
		else						// Naar SE gaan
		{
			d += deltaSE;
			deltaE += 2;
			deltaSE += 4;
			y--;
		}
		x++;
		DrawAllCirclePoints(Midx, Midy, x, y, color);
	}
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
		ET.Initialize(Polygon);
		printf("\nET:\n---\n");
		ET.Writedata();
		printf("\nAET:\n----\n");

		int y = MinimumY;
		while(y <= MaximumY)
		{
			CG1_EdgeTableRow* Edges; 
			Edges = ET.GetEdgeTableRow(y);

			// Voeg de nodige edges toe
			AET.Add(Edges);
			AET.Writedata(y);

			// Teken de data
			int Pariteit = 2;	// (2 = tekenen | 1 = niet tekenen)
			int FirstX, SecondX;

			CG1_Edge* CurrentEdge;

			for(AET.ActiveEdgeIterator = AET.ActiveEdges.begin(); AET.ActiveEdgeIterator != AET.ActiveEdges.end(); AET.ActiveEdgeIterator++)
			{
				CurrentEdge = *(AET.ActiveEdgeIterator);
				if(Pariteit == 2)
				{
					FirstX = (int)CurrentEdge->Current_X;
					Pariteit = 1;
				}
				else if(Pariteit == 1)
				{
					SecondX = (int)CurrentEdge->Current_X;
					DrawMidPointLine(CG1_Line( (int)FirstX, y, (int)SecondX, y), color);
					//printf("Drawn: FirstX: %d  SecondX: %d\n", (int)FirstX, (int)SecondX);
					Pariteit = 2;
				}
			}


			// update de AET voor de volgende scanline
			y++;							
			// verwijder overbodige edges
			AET.RemoveObsoleteEdges(y);				//zorgt ervoor dat ymax niet mee in de pariteit voorkomt
			AET.Update_CurrentX_Values();
		}
	}
}
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
	bool accept, done;
	CG1_OutCode OutCode0, OutCode1, OutCodeOut;

	float x,y;
	float x0 = (float)Line->X0();
	float y0 = (float)Line->Y0();
	float x1 = (float)Line->X1();
	float y1 = (float)Line->Y1();

	accept = false;
	done = false;

	OutCode0 = CompOutCode(x0, y0);
	OutCode1 = CompOutCode(x1, y1);

	do
	{
		if(OutCode0.all == 0 && OutCode1.all == 0)			//triviaal aanvaard
		{
			accept = true;
			done = true;
		}
		else if((OutCode0.all & OutCode1.all) != 0)			//triviaal geweigerd
		{
			accept = false;
			done = true;
		}
		else								//intersectie berekenen
		{
			if(OutCode0.all != 0)			//een buiten de cliprectangle liggend punt (all != 0) verbeteren
			{
				OutCodeOut = OutCode0;
			}
			else
			{
				OutCodeOut = OutCode1;
			}

			if(OutCodeOut.top)						// intersectie met bovenkant berekenen
			{
				x = x0 + ((x1 - x0) * ((ClipTop - y0) / (y1 - y0)));
				y = ClipTop;
			}
			else if(OutCodeOut.bottom)					// intersectie met onderkant berekenen
			{
				x = x0 + ((x1 - x0) * ((ClipBottom - y0) / (y1 - y0)));
				y = ClipBottom;
			}
			else if(OutCodeOut.right)					// intersectie met rechterkant berekenen
			{
				y = y0 + ((y1 - y0) * ((ClipRight - x0) / (x1 - x0)));
				x = ClipRight;
			}
			else if(OutCodeOut.left)					// intersectie met linkerkant berekenen
			{
				y = y0 + ((y1 - y0) * ((ClipLeft - x0) / (x1 - x0)));
				x = ClipLeft;
			}

			if(OutCodeOut.all == OutCode0.all)			// nieuwe outcodes bepalen
			{
				x0 = x;
				y0 = y;
				OutCode0 = CompOutCode(x0, y0);
			}
			else
			{
				x1 = x;
				y1 = y;
				OutCode1 = CompOutCode(x1, y1);
			}
		}
	}
	while(!done);

	if(accept)		//teken de lijn
	{
		Line->SetData(x0, y0, x1, y1);
		return true;
	}
	else
	{
		return false;
	}
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
	CG1_2DVector first, second;
	CG1_2DPolygon *OldPolygon, *NewPolygon;
	NewPolygon = new CG1_2DPolygon();
	OldPolygon = Polygon;										// initieel de InPolygon

	if(OldPolygon->GetSize() > 1)
	{
		int EdgeNr;
		int Value;
		for(EdgeNr=0; EdgeNr<4; EdgeNr++)
		{	
			switch(EdgeNr)
			{
			case 0:		// onder
				{
					Value = ClipBottom;
					break;
				}
			case 1:		// rechts
				{
					Value = ClipRight;
					break;
				}
			case 2:		// boven
				{
					Value = ClipTop;
					break;
				}
			case 3:		// links
				{
					Value = ClipLeft;
					break;
				}
			}

			first = OldPolygon->GetPoint(OldPolygon->GetSize() - 1);			// initieel de laatste

			for(int i=0; i<OldPolygon->GetSize(); i++)					// test alle old points
			{
				second = OldPolygon->GetPoint(i);

				if( Inside(first, EdgeNr, Value) && Inside(second, EdgeNr, Value) )	// case 1
				{
					//NewPolygon updaten
					//alleen second toevoegen
					NewPolygon->AddPoint(second);
				}
				else if( Inside(first, EdgeNr, Value) )					// case 2
				{
					//NewPolygon updaten
					//alleen intersection toevoegen
					CG1_2DVector intersection;
					intersection = GetIntersection(first, second, EdgeNr, Value);
					NewPolygon->AddPoint(intersection);

				}
				else if( Inside(second, EdgeNr, Value) )				// case 3
				{
					//NewPolygon updaten
					//eerst intersection en dan second toevoegen
					CG1_2DVector intersection;
					intersection = GetIntersection(first, second, EdgeNr, Value);
					NewPolygon->AddPoint(intersection);
					NewPolygon->AddPoint(second);
				}
				else													// case 4
				{
					//NewPolygon updaten
					//niks doen
				}

				first = second;
			}

			*OldPolygon = *NewPolygon;
			NewPolygon->Clear();
		}

		Polygon = OldPolygon;
		delete NewPolygon;	
	}
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
	start = ModelViewMatrix * start;
	end = ModelViewMatrix * end;

	start = ProjectionMatrix * start;
	end = ProjectionMatrix * end;

	start.DivideByW();
	end.DivideByW();

	CG1_Line The_Line = CG1_Line((int)start.GetX(), (int)start.GetY(), (int)end.GetX(), (int)end.GetY());

	if(CyrusBeckClip(&The_Line))
		DrawMidPointLine(The_Line, color);
}

//--------------------------------------------------------------------

void CG1_DrawTool::PushMatrix()
{
	MatrixStack.push(ModelViewMatrix);
}

//--------------------------------------------------------------------

void CG1_DrawTool::PopMatrix()
{
	if(MatrixStack.size() > 0)
	{
		ModelViewMatrix = MatrixStack.top();
		MatrixStack.pop();
	}
}

//--------------------------------------------------------------------

void CG1_DrawTool::ModifyView(char axe, int amount)
{
	switch(axe)
	{
	case 'x':
		{
			Camera_X += amount;
			break;
		}
	case 'y':	
		{
			Camera_Y += amount;
			break;
		}
	case 'z':	
		{
			Camera_Z += amount;
			break;	
		}
	case 'r':	
		{
			Scene_RotationY += amount;
			break;
		}
	}
}

//--------------------------------------------------------------------

std::string GetSubStringFrom(std::string BeginString, int NewBeginPos)
{
	int length = BeginString.length();
	return BeginString.substr(NewBeginPos+1, length - NewBeginPos);
}

//--------------------------------------------------------------------

void CG1_DrawTool::LoadFromFile(char* filename)
{
    printf("File reading...\n\n");
    FILE* File;
    File = fopen(filename, "r");
    if( File != NULL)
    {
	char Line[500];
	char DataType;
	fgets(Line, 500, File);
	while( !feof( File ) )
	{
            sscanf(Line, "%c", &DataType);
	    
	    switch(DataType)
	    {
		case 'v':
		{
		    int Vertex_index;
		    double X;
		    double Y;
		    double Z;
                    sscanf(Line, "%c %d %lf %lf %lf", &DataType, &Vertex_index, &X, &Y, &Z);
		    printf("%c: (%d) %5.2lf %5.2lf %5.2lf\n", DataType, Vertex_index, X, Y, Z);
		    fgets(Line, 500, File);
		    break;
		}
		case 'p':
		{
		    int Polygon_index;
                    sscanf(Line, "%c %d", &DataType, &Polygon_index);
		    printf("%c: (%d) ", DataType, Polygon_index);
		    
		    std::string MySpaceString(Line);
		    int Vertex_index, SpacePos;
		    SpacePos = MySpaceString.find(' ', 2);
		    while (SpacePos != -1)
		    {
			MySpaceString = GetSubStringFrom(MySpaceString, SpacePos);
                        sscanf(MySpaceString.c_str(), "%d", &Vertex_index);
			printf("%d ", Vertex_index);
			SpacePos = MySpaceString.find(' ');
			
		    }
		    printf("\n");
		    fgets(Line, 500, File);
		    break;
		}
		case 'o':
		{
		    int Object_index;
                    sscanf(Line, "%c %d", &DataType, &Object_index);
		    printf("%c: (%d) ", DataType, Object_index);
		    
		    std::string MyString(Line);
		    int Polygon_index, SpacePos;
		    SpacePos = MyString.find(' ', 2);
		    while (SpacePos != -1)
		    {
			MyString = GetSubStringFrom(MyString, SpacePos);
                        sscanf(MyString.c_str(), "%d", &Polygon_index);
			printf("%d ", Polygon_index);
			SpacePos = MyString.find(' ');
		    }
		    printf("\n");
		    fgets(Line, 500, File);
		    break;
		}
		case 'b':
		{
		    int Bezier_index, ittype, itsteps;
                    sscanf(Line, "%c %d %d %d", &DataType, &Bezier_index, &ittype, &itsteps);
		    printf("%c: (%d) -> Method: %d, Steps: %d\n", DataType, Bezier_index,ittype, itsteps);
		    
		    std::string MyString(Line);
		    int Vertex_index, SpacePos;
		    SpacePos = MyString.find('|', 0);
		    while (SpacePos != -1)
		    {
			MyString = GetSubStringFrom(MyString, SpacePos);
                        sscanf(MyString.c_str(), "%d", &Vertex_index);
			printf("%d ", Vertex_index);
			SpacePos = MyString.find(' ');
		    }
		    printf("\n");
		    fgets(Line, 500, File);
		    break;
		}
		default :
		{
		    printf("\n");
		    fgets(Line, 500, File);
		    break;
		}
	    }
	}
	printf("\nfinished (no errors)\n");
	
//	printf("=> %d objects added, ", ObjectList.GetSize());
//	printf("containing %d polygons, ", PolygonList.GetSize());
//	printf("using %d vertices.\n", VertexList.GetSize());
//	printf("%d beziers added.\n", BezierList.GetSize());
    }
    else
    {
	printf("\nCould not open file : %s\n\n", filename);
    }	
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawObjectFromList(int index, RGB_Color color)
{
    //todo
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawPolygonFromList(int index, RGB_Color color)
{
    //todo
}

//--------------------------------------------------------------------

void CG1_DrawTool::DrawBezierFromList(int index, RGB_Color color)
{
    //todo
}

//--------------------------------------------------------------------

