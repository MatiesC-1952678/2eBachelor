#ifndef __OBJECT_BEZIER_H__
#define __OBJECT_BEZIER_H__

#include <vector>
#include "RGB_Color.h"
#include "CG1_Bezier.h"

class Object_Bezier  
{
public:
	Object_Bezier();
	virtual ~Object_Bezier();

	int getVertexIndex(int position);
	int getNrOfVertexIndices();
	CG1_Bezier* getBezier();
	void setNrOfSteps( int nr );
	void setMethod(Iteration_Method method);
	void addVertex(int index, CG1_4DVector p );
	void iterate();
	
private:
	std::vector<int> m_Vertices;	// de vertices uit de vertexlijst
	CG1_Bezier m_Bezier;		// een instantie van de CG1_Bezier klasse
	int m_NrOfSteps;
};

#endif // __OBJECT_BEZIER_H__
