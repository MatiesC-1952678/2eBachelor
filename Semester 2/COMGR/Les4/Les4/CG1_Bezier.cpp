#include "CG1_Bezier.h"

//--------------------------------------------------------------------

CG1_Bezier::CG1_Bezier()
{
    m_CtrlIndex = 0;
    m_Index = 0;
    m_IterationMethod = BRUTEFORCE;
    m_BaseMatrix[0] = -1.0;			//  0     1     2     3
    m_BaseMatrix[1] = 3.0;			
    m_BaseMatrix[2] = -3.0;			//  4     5     6     7
    m_BaseMatrix[3] = 1.0;
    m_BaseMatrix[4] = 3.0;			//  8     9     10    11
    m_BaseMatrix[5] = -6.0;
    m_BaseMatrix[6] = 3.0;			//  12    13    14    15
    m_BaseMatrix[7] = 0.0;
    m_BaseMatrix[8] = -3.0;
    m_BaseMatrix[9] = 3.0;
    m_BaseMatrix[10] = 0.0;
    m_BaseMatrix[11] = 0.0;
    m_BaseMatrix[12] = 1.0;
    m_BaseMatrix[13] = 0.0;
    m_BaseMatrix[14] = 0.0;
    m_BaseMatrix[15] = 0.0;
}

//--------------------------------------------------------------------

CG1_Bezier::~CG1_Bezier()
{
    
}

//--------------------------------------------------------------------

void CG1_Bezier::iterate( int nrofsteps )
{
    m_PointVector.clear();
    createGeoMatrix();
    clearPoints();
    
    switch(m_IterationMethod)
    {
    case CASTELJAU:
	{
	    Casteljau(nrofsteps);
	    break;
	}
    case FD:
	{
	    ForwardDiff(nrofsteps);
	    break;
	}
    default:
	{
	    BruteForce(nrofsteps);
	    break;
	}
    }
}

//--------------------------------------------------------------------

bool CG1_Bezier::createGeoMatrix()
{
    if(m_CtrlIndex < 4)
	return false;
    
    for(int i = 0; i < 4; i++)
    {
	    m_GeoMatrix[0+i] = m_CtrlPointVector[i].GetX();
	    m_GeoMatrix[4+i] = m_CtrlPointVector[i].GetY();
	    m_GeoMatrix[8+i] = m_CtrlPointVector[i].GetZ();
    }
    return true;
}

//--------------------------------------------------------------------

void CG1_Bezier::setIterationMethod(enum Iteration_Method m)
{
    m_IterationMethod = m;
}

//--------------------------------------------------------------------

void CG1_Bezier::BruteForce ( int nrofsteps )
{
    //todo
}

//--------------------------------------------------------------------

void CG1_Bezier::Casteljau  ( int nrofsteps )
{
    //todo	
}

//--------------------------------------------------------------------

void CG1_Bezier::ForwardDiff( int nrofsteps )
{
    //todo
}

//--------------------------------------------------------------------
