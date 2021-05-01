#ifndef __CG1_PARAMCUBCURVE_H__
#define __CG1_PARAMCUBCURVE_H__

//Includes
#include <vector>
#include "RGB_Color.h"
#include "CG1_4DVector.h"

class CG1_ParamCubCurve  
{
public:
	CG1_ParamCubCurve();
	virtual ~CG1_ParamCubCurve();

	int getNrOfCtrlPoints();
	int getNrOfPoints();
	CG1_4DVector getCtrlPoint( int index = 0 );
	CG1_4DVector getNextCtrlPoint();
	CG1_4DVector getPoint( int index = 0 );
	CG1_4DVector getNextPoint();
	void addCtrlPoint( CG1_4DVector p );
	void clearCtrlPoints();
	
protected:
	void evaluate( double t, CG1_4DVector & p );
	void addPoint( CG1_4DVector p );
	void clearPoints();
	
protected:
	double m_GeoMatrix[12];		// Geometry matrix 
	double m_BaseMatrix[16];	// Base matrix

	int m_CtrlIndex;			// Nr of controlpoints
	int m_Index;				// Nr of points
	
	std::vector<CG1_4DVector> m_CtrlPointVector;	// STL-vector of controlpoints (CG1_4DVectors)
	std::vector<CG1_4DVector> m_PointVector;		// STL-vector of points (CG1_4DVectors)

};

#endif // __CG1_PARAMCUBCURVE_H__
