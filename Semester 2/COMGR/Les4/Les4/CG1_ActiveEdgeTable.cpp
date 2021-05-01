// CG1_ActiveEdgeTable.cpp: implementation of the CG1_ActiveEdgeTable class.
//
//////////////////////////////////////////////////////////////////////

#include "CG1_ActiveEdgeTable.h"
#include <stdio.h>

//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////
//--------------------------------------------------------------------

CG1_ActiveEdgeTable::CG1_ActiveEdgeTable()
{

}

//--------------------------------------------------------------------

CG1_ActiveEdgeTable::~CG1_ActiveEdgeTable()
{

}

//--------------------------------------------------------------------

void CG1_ActiveEdgeTable::Add(CG1_EdgeTableRow *EdgeRow)
{
	CG1_Edge* CurrentEdge;
	for(EdgeRow->EdgeIterator = EdgeRow->Edges.begin(); EdgeRow->EdgeIterator != EdgeRow->Edges.end(); EdgeRow->EdgeIterator++)
	{
		CurrentEdge = *(EdgeRow->EdgeIterator);
		CurrentEdge->Current_X = (float)CurrentEdge->x_down;	// initializeren op de laagste waarde
		Add(CurrentEdge);
	}
}

//--------------------------------------------------------------------

void CG1_ActiveEdgeTable::Add(CG1_Edge *Edge)
{
	if(Edge->y_down != Edge->y_up)	// horizontale lijnen tellen niet mee voor de pariteit
	{
		int X = Edge->Current_X;
		CG1_Edge *CurrentEdge;
		bool inserted = false;
		for(ActiveEdgeIterator = ActiveEdges.begin(); ActiveEdgeIterator != ActiveEdges.end() && !inserted; ActiveEdgeIterator++)
		{
			CurrentEdge = *ActiveEdgeIterator;
			int TestX = CurrentEdge->Current_X;
			if(X == TestX)	// zodat punten met een zelfde xmin toch in de juiste volgorde toegevoegd worden
			{
				if(Edge->Reversed_M < CurrentEdge->Reversed_M)
				{
					ActiveEdges.insert(ActiveEdgeIterator, Edge);
					inserted = true;
				}
			}
			else if(TestX > X)
			{
				ActiveEdges.insert(ActiveEdgeIterator, Edge);
				inserted = true;
			}
		}
		if(!inserted)
		{
			ActiveEdges.push_back(Edge);
		}
	}
}

//--------------------------------------------------------------------

void CG1_ActiveEdgeTable::Writedata(int y_value)
{
	if(ActiveEdges.size() > 0)
	{
		printf("%d: ", y_value);
		CG1_Edge* CurrentEdge;
		for(ActiveEdgeIterator = ActiveEdges.begin(); ActiveEdgeIterator != ActiveEdges.end(); ActiveEdgeIterator++)
		{
			CurrentEdge = *ActiveEdgeIterator;
			printf(" x = %.2f ", CurrentEdge->Current_X);
		}
		printf("\n");
	}
	else
	{
		printf("%d: empty\n", y_value);
	}
}

//--------------------------------------------------------------------

void CG1_ActiveEdgeTable::Update_CurrentX_Values()
{
	CG1_Edge *CurrentEdge;
	for(ActiveEdgeIterator = ActiveEdges.begin(); ActiveEdgeIterator != ActiveEdges.end(); ActiveEdgeIterator++)
	{
		CurrentEdge = *ActiveEdgeIterator;
		CurrentEdge->Current_X += CurrentEdge->Reversed_M;
	}
}

//--------------------------------------------------------------------

void CG1_ActiveEdgeTable::RemoveObsoleteEdges(int y)
{
	CG1_Edge *CurrentEdge;
	ActiveEdgeIterator = ActiveEdges.begin();
	while(ActiveEdgeIterator != ActiveEdges.end())
	{
		CurrentEdge = *ActiveEdgeIterator;
		if(CurrentEdge->y_up == y)
		{
			ActiveEdgeIterator = ActiveEdges.erase(ActiveEdgeIterator);
		}
		else
		{
			ActiveEdgeIterator++;
		}
	}
}
