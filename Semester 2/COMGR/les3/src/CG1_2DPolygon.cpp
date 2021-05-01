// CG1_Polygon.cpp: implementation of the CG1_Polygon class.
//
//////////////////////////////////////////////////////////////////////

#include "CG1_2DPolygon.h"

//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////
//--------------------------------------------------------------------

CG1_2DPolygon::CG1_2DPolygon()
{

}

//--------------------------------------------------------------------

CG1_2DPolygon::~CG1_2DPolygon()
{

}

//--------------------------------------------------------------------

void CG1_2DPolygon::AddPoint(CG1_2DVector NewPoint)			// PUNT TOEVOEGEN
{
	Points.reserve(Points.size() + 1);
	Points.push_back(NewPoint);

}

//--------------------------------------------------------------------

CG1_2DVector CG1_2DPolygon::GetPoint(int index)				// PUNT OPVRAGEN
{
	return Points[index];
}

//--------------------------------------------------------------------

int CG1_2DPolygon::GetSize()									// GROOTTE OPVRAGEN
{
	return Points.size();
}

//--------------------------------------------------------------------

void CG1_2DPolygon::Clear()									// LEEG MAKEN
{
	Points.clear();
}

//--------------------------------------------------------------------

CG1_2DPolygon &CG1_2DPolygon::operator=(const CG1_2DPolygon &p)	// TOEKENNINGS-OPERATOR
{
	Points.clear();
	int NrOfPoints = p.Points.size();
	Points.reserve(NrOfPoints);
	
	for(int i=0; i<NrOfPoints; i++)
	{
		CG1_2DVector CurrentVector;
		CurrentVector = p.Points[i];
		AddPoint(CurrentVector);	
	}
	return *this;
}

//--------------------------------------------------------------------

int CG1_2DPolygon::GetLowestY()
{
	int NrOfPoints = Points.size();
	int lowestY = 100000;
	for(int i=0; i<NrOfPoints; i++)
	{
		CG1_2DVector CurrentVector;
		CurrentVector = Points[i];
		int y = CurrentVector.GetY();
		if(y < lowestY)
			lowestY = y;
	}
	return lowestY;
}

//--------------------------------------------------------------------

int CG1_2DPolygon::GetHighestY()
{
	int NrOfPoints = Points.size();
	int highestY = -100000;
	for(int i=0; i<NrOfPoints; i++)
	{
		CG1_2DVector CurrentVector;
		CurrentVector = Points[i];
		int y = CurrentVector.GetY();
		if(y > highestY)
			highestY = y;
	}
	return highestY;
}

//--------------------------------------------------------------------
